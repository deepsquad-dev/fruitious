<template>
    <div class="min-h-screen bg-yellow-500 bg-auto">
        <div class="text-3xl text-yellow-900 text-center p-8">
            <h1>Fruitious</h1>
        </div>
        <div class="">
            <div class="grid content-center">
                <slot />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Layout"
}
</script>

<style scoped>

</style>
