<template>
    <div class="cells" style="--cols: 3fr 3fr 1fr">
        <div class="cell-l">
            <div>
                <a class="font-sans-bold link-underline link-blue" :href="repository.url" target="_blank" rel="nofollow noreferrer noopener">
                    {{ repository.name }}
                </a>
            </div>
            <div class="text-xs mt-2 text-grey">
                <span v-if="repository.language" class="font-bold">
                    {{ repository.language }}
                    <span class="char-separator">•</span>
                </span>
                <span v-if="repository.download_count">
                    {{ repository.formatted_download_count }} <i class="fal fa-arrow-to-bottom"></i>
                    <span class="char-separator">•</span>
                </span>
                {{ repository.formatted_star_count }} <i class="fal fa-star"></i>
                <a v-if="repository.has_issues" :href="repository.issues_url" target="_blank" rel="nofollow noreferrer noopener"
                    class="bg-green-lightest text-green-dark rounded-full px-2 ml-2">
                    easy issues
                </a>
                <span v-if="repository.is_new" class="bg-gold-lightest text-gold-darkest rounded-full px-2 ml-2">
                    new
                </span>
            </div>
        </div>
        <div class="cell">
            {{ repository.description }}
            <div class="text-xs mt-2 text-grey">
                <span v-for="(topic, i) in repository.topics" :key="topic">
                    {{ topic }}
                    <span v-if="i !== repository.topics.length - 1" class="char-separator">•</span>
                </span>
            </div>
        </div>
        <div class="cell-r grid-text-right flex flex-col justify-center">
            <a v-if="repository.documentation_url" :href="repository.documentation_url" target="_blank" rel="nofollow noreferrer noopener"
                class="link-underline link-grey text-xs">
                Documentation
            </a>
            <a v-if="repository.blogpost_url" :href="repository.blogpost_url" target="_blank" rel="nofollow noreferrer noopener"
                class="link-underline link-grey text-xs">
                Blogpost
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        repository: { required: true },
    },
}
</script>

