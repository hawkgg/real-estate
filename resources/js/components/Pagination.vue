<template>
    <nav v-if="info.last_page > 1" class="mt-3">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: info.current_page === 1 }">
                <a @click.prevent="$emit('paginate', info.current_page - 1)"
                   class="page-link"
                   href="">
                    Назад
                </a>
            </li>
            <template v-for="link in info.links">
                <li v-if="Number(link.label) &&
                                (link.label - info.current_page < 3) &&
                                (info.current_page - link.label < 3)"
                    :class="{ active: link.active }"
                    :aria-current="link.active ? 'page' : null"
                    class="page-item">
                    <a @click.prevent="$emit('paginate', link.label)"
                       class="page-link"
                       href="">
                        {{ link.label }}
                    </a>
                </li>
            </template>
            <li :class="{ disabled: info.current_page === info.last_page }"
                class="page-item">
                <a @click.prevent="$emit('paginate', info.current_page + 1)"
                   class="page-link"
                   href="">
                    Вперёд
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "Pagination",
    props: ['info']
}
</script>

<style scoped>
    .page-item.active {
        pointer-events: none;
        cursor: default;
    }
</style>
