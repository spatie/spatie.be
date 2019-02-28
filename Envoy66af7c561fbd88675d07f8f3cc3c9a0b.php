<?php $message = isset($message) ? $message : null; ?>
<?php $user = isset($user) ? $user : null; ?>
<?php $newReleaseDir = isset($newReleaseDir) ? $newReleaseDir : null; ?>
<?php $newReleaseName = isset($newReleaseName) ? $newReleaseName : null; ?>
<?php $currentDir = isset($currentDir) ? $currentDir : null; ?>
<?php $releasesDir = isset($releasesDir) ? $releasesDir : null; ?>
<?php $baseDir = isset($baseDir) ? $baseDir : null; ?>
<?php $repository = isset($repository) ? $repository : null; ?>
<?php $userAndServer = isset($userAndServer) ? $userAndServer : null; ?>
<?php $server = isset($server) ? $server : null; ?>
<?php
require __DIR__.'/vendor/autoload.php';
(new \Dotenv\Dotenv(__DIR__, '.env'))->load();

$server = "spatie.be";
$userAndServer = 'forge@'. $server;
$repository = "spatie/spatie.be";
$baseDir = "/home/forge/spatie.be";
$releasesDir = "{$baseDir}/releases";
$currentDir = "{$baseDir}/current";
$newReleaseName = date('Ymd-His');
$newReleaseDir = "{$releasesDir}/{$newReleaseName}";
$user = get_current_user();

function logMessage($message) {
return "echo '\033[32m" .$message. "\033[0m';\n";
}
?>

<?php $__container->servers(['local' => '127.0.0.1', 'remote' => $userAndServer]); ?>

<?php $__container->startMacro('deploy'); ?>
startDeployment
cloneRepository
runComposer
runYarn
generateAssets
updateSymlinks
optimizeInstallation
backupDatabase
migrateDatabase
blessNewRelease
cleanOldReleases
finishDeploy
<?php $__container->endMacro(); ?>

<?php $__container->startMacro('deploy-code'); ?>
deployOnlyCode
<?php $__container->endMacro(); ?>

<?php $__container->startTask('startDeployment', ['on' => 'local']); ?>
<?php echo logMessage("🏃  Starting deployment..."); ?>

git checkout master
git pull origin master
<?php $__container->endTask(); ?>

<?php $__container->startTask('cloneRepository', ['on' => 'remote']); ?>
<?php echo logMessage("🌀  Cloning repository..."); ?>

[ -d <?php echo $releasesDir; ?> ] || mkdir <?php echo $releasesDir; ?>;
cd <?php echo $releasesDir; ?>


# Create the release dir
mkdir <?php echo $newReleaseDir; ?>


# Clone the repo
git clone --depth 1 git@github.com:<?php echo $repository; ?> <?php echo $newReleaseName; ?>


# Configure sparse checkout
cd <?php echo $newReleaseDir; ?>

git config core.sparsecheckout true
echo "*" > .git/info/sparse-checkout
echo "!storage" >> .git/info/sparse-checkout
echo "!public/build" >> .git/info/sparse-checkout
git read-tree -mu HEAD

# Mark release
cd <?php echo $newReleaseDir; ?>

echo "<?php echo $newReleaseName; ?>" > public/release-name.txt
<?php $__container->endTask(); ?>

<?php $__container->startTask('runComposer', ['on' => 'remote']); ?>
<?php echo logMessage("🚚  Running Composer..."); ?>

cd <?php echo $newReleaseDir; ?>

composer install --prefer-dist --no-scripts --no-dev -q -o
<?php $__container->endTask(); ?>

<?php $__container->startTask('runYarn', ['on' => 'remote']); ?>
<?php echo logMessage("📦  Running Yarn..."); ?>

cd <?php echo $newReleaseDir; ?>

yarn config set ignore-engines true
yarn
<?php $__container->endTask(); ?>

<?php $__container->startTask('generateAssets', ['on' => 'remote']); ?>
<?php echo logMessage("🌅  Generating assets..."); ?>

cd <?php echo $newReleaseDir; ?>

yarn run production --progress false
<?php $__container->endTask(); ?>

<?php $__container->startTask('updateSymlinks', ['on' => 'remote']); ?>
<?php echo logMessage("🔗  Updating symlinks to persistent data..."); ?>

# Remove the storage directory and replace with persistent data
rm -rf <?php echo $newReleaseDir; ?>/storage
cd <?php echo $newReleaseDir; ?>

ln -nfs <?php echo $baseDir; ?>/persistent/storage storage

# Remove the public/media directory and replace with persistent data
rm -rf <?php echo $newReleaseDir; ?>/public/images/medialibrary
cd <?php echo $newReleaseDir; ?>

ln -nfs <?php echo $baseDir; ?>/persistent/medialibrary public/images/medialibrary

# Import the environment config
cd <?php echo $newReleaseDir; ?>

ln -nfs <?php echo $baseDir; ?>/.env .env
<?php $__container->endTask(); ?>

<?php $__container->startTask('optimizeInstallation', ['on' => 'remote']); ?>
<?php echo logMessage("✨  Optimizing installation..."); ?>

cd <?php echo $newReleaseDir; ?>

php artisan clear-compiled
<?php $__container->endTask(); ?>

<?php $__container->startTask('backupDatabase', ['on' => 'remote']); ?>
<?php echo logMessage("📀  Backing up database..."); ?>

cd <?php echo $newReleaseDir; ?>

php artisan backup:run
<?php $__container->endTask(); ?>

<?php $__container->startTask('migrateDatabase', ['on' => 'remote']); ?>
<?php echo logMessage("🙈  Migrating database..."); ?>

cd <?php echo $newReleaseDir; ?>

php artisan migrate --force
php artisan db:seed --class MembersSeeder --force
<?php $__container->endTask(); ?>

<?php $__container->startTask('blessNewRelease', ['on' => 'remote']); ?>
<?php echo logMessage("🙏  Blessing new release..."); ?>

ln -nfs <?php echo $newReleaseDir; ?> <?php echo $currentDir; ?>

cd <?php echo $newReleaseDir; ?>


php artisan horizon:terminate
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan view:cache
php artisan responsecache:clear

sudo service php7.2-fpm restart
sudo supervisorctl restart all
<?php $__container->endTask(); ?>

<?php $__container->startTask('cleanOldReleases', ['on' => 'remote']); ?>
<?php echo logMessage("🚾  Cleaning up old releases..."); ?>

# Delete all but the 5 most recent.
cd <?php echo $releasesDir; ?>

ls -dt <?php echo $releasesDir; ?>/* | tail -n +6 | xargs -d "\n" sudo chown -R forge .
ls -dt <?php echo $releasesDir; ?>/* | tail -n +6 | xargs -d "\n" rm -rf
<?php $__container->endTask(); ?>

<?php $__container->startTask('finishDeploy', ['on' => 'local']); ?>
<?php echo logMessage("🚀  Application deployed!"); ?>

<?php $__container->endTask(); ?>

<?php $__container->startTask('deployOnlyCode',['on' => 'remote']); ?>
<?php echo logMessage("💻  Deploying code changes..."); ?>

cd <?php echo $currentDir; ?>

git pull origin master
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan view:cache
php artisan responsecache:clear
sudo service php7.2-fpm restart
php artisan horizon:terminate
sudo supervisorctl restart all
<?php $__container->endTask(); ?>
