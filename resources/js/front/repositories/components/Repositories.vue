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
                    class="border-2 border-grey-lighter bg-white rounded-full p-4 outline-0 focus:border-blue"
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
                        <span class="icon fill-grey"><AngleDownIcon /></span>
                    </div>
                </div>
                <div v-if="repositories.length">
                    <Repository
                        v-for="repository in repositories"
                        :key="repository.id"
                        :repository="repository"
                    />
                </div>
                <p v-else class="mt-12 text-lg text-grey">
                    Apparently there's not a Spatie package for everything! <br>
                    Maybe check back later.
                </p>
            </div>
        </template>
    </DataComponent>
</template>

<script>
import Repository from './Repository';
import DataComponent, { createFetcher } from 'vue-data-component';
import AngleDownIcon from './icons/AngleDownIcon';

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
        AngleDownIcon,
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
};
</script>
