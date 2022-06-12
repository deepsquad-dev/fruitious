<template>
    <Head title="Update" />
    <div class="max-w-md mx-auto justify-center bg-white rounded-xl shadow overflow-hidden md:max-w-2xl">
        <div class="p-12">
            <div class="px-3 text-slate-500">
                <p class="py-2">
                    Click on any item on the list to make changes.
                </p>
                <Link href="/fruit">Edit the name of your item.</Link>
            </div>

            <form @submit.prevent="submit">
                <div class="rounded-l py-4 px-3">
                        <label class="text-slate-400 py-2 px-4"
                               for="name"
                        >name
                        </label>
                        <input v-model="form.name"
                               class="text-slate-500 rounded py-2 px-4 bg-green-100"
                               type="text"
                               name="name"
                               id="name"
                               required
                        >
                </div>
                <div class="py-4 px-3">
                    <button type="submit"
                            class="py-2 px-3 rounded-full bg-green-400"
                            :disabled="form.processing"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';

let props = defineProps({
    data: Object,
})

let form = useForm({
    id: props.data.id,
    name: props.data.name,
});

let submit = () => {
    console.log(props.data.id+"/update")
    form.put("/update/"+props.data.id);
};
</script>

<style scoped>

</style>
