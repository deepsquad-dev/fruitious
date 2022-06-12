<template>
    <Head title="Main" />
    <div class="max-w-md mx-auto justify-center bg-white rounded-xl shadow overflow-hidden md:max-w-2xl mb-12">
        <div class="p-12">
            <div class="px-3 text-slate-500">
                <p class="py-2">
                    Click on any item on the list to make changes.
                </p>
                <div class="py-4">
                    <Link class="py-2 px-3 rounded-full bg-amber-400" href="/fruit">Fetch fruit</Link>
                </div>
            </div>
            <div class="">
                <table class="text-slate-600">
                    <tbody class="">
                    <tr
                        v-for="item in items.data"
                        :key="item.id"
                        class=""
                    >
                        <td class="py-2 px-3">
                            <div :class="item.depth">
                                <span class="px-3">{{ item.emoji }}</span>
                                <a :href="`${item.id}/edit`">
                                    {{ item.name }}
                                </a>
                            </div>
                        </td>
                        <td class="py-2 px-3">
                            <a :href="`${item.id}/destroy`">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
    <!--    <ul>-->
    <!--        <li-->
    <!--            v-for="item in items.data"-->
    <!--            :key="item.id"-->
    <!--            v-text="item.name"-->
    <!--        />-->
    <!--    </ul>-->
            </div>
    </div>
</template>

<script setup>
import { Link }  from '@inertiajs/inertia-vue3';

let props = defineProps({
    items: Array,
});
</script>

<style scoped>
.padding-0 {
    padding-left: 0px;
}
.padding-4 {
    padding-left: 8px;
}
.padding-8 {
    padding-left: 16px;
}
.padding-12 {
    padding-left: 32px;
}
.padding-16 {
    padding-left: 64px;
}
</style>

