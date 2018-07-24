<template>
    <DataComponent
        :fetcher="fetcher"
        :filter="filter"
        :sort="sort"
        data-key="repositories"
    >
        <template slot-scope="{ repositories }">
            <div v-if="filterable" class="wrap flex justify-center mb-8">
                <input
                    type="search"
                    class="border-2 border-grey-lighter bg-white rounded-full p-4 outline-0 focus:border-pink"
                    :placeholder="`Search ${label}…`"
                    v-model="filter"
                >
            </div>
            <div class="wrap">
                <div v-if="filterable" class="flex items-baseline">
                    <h3 class="title-sm text-grey mb-4">
                        <span v-if="filter">
                            Filtered {{ label }}
                        </span>
                        <span v-else>
                            All {{ label }}
                        </span>
                    </h3>
                    <div class="sort">
                        <select class="sort-select outline-0" v-model="sort">
                            <option value="name">by name</option>
                            <option value="-star_count">by popularity</option>
                            <option value="-repository_created_at">by date</option>
                        </select>
                        <i class="sort-arrow far fa-angle-down"></i>
                    </div>
                </div>
                <Repository
                    v-for="repository in repositories"
                    :key="repository.id"
                    :repository="repository"
                />
            </div>
        </template>
    </DataComponent>
</template>

<script>
import Repository from './Repository';
import DataComponent, { createFetcher } from 'vue-data-component';

export default {
    props: {
        repositories: { required: true, type: Array },
        filterable: { default: false },
        label: { default: 'packages' },
    },

    data: () => ({
        filter: '',
        sort: '-star_count',
    }),

    components: {
        Repository,
        DataComponent,
    },

    computed: {
        fetcher() {
            const repositories = this.repositories.map(repository => ({
                ...repository,
                query: `${repository.name}${repository.topics.join('')}`,
            }));

            return createFetcher(repositories, {
                filterBy: ['query'],
            });
        },
    },
}
</script>
