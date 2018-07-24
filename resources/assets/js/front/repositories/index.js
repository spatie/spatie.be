import Vue from 'vue';
import Repositories from './components/Repositories';

export default function repositories(el) {
    const vm = new Vue({
        render(h) {
            return h(Repositories, {
                props: {
                    repositories: JSON.parse(el.dataset.repositories),
                    filterable: el.dataset.hasOwnProperty('filterable'),
                    label: el.dataset.label,
                },
            });
        }
    });

    vm.$mount(el);
}
