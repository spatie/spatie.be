{{ Menu::service()
    ->addItemClass($dark && ($footer ?? false) ? 'hover:text-oss-royal-blue-light' : 'text-oss-royal-blue-light sm:text-oss-royal-blue')
    ->setActiveClass('font-bold') }}
