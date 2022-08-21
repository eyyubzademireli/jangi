<template>
    <div class="w-full h-full fixed top-0 left-0 z-50">
        <div @click="$emit('close')" class="w-full h-full fixed top-0 left-0 bg-gray-500 opacity-75 -z-30"></div>
        <div class="w-full h-full flex justify-center items-center z-40">
            <div class="min-w-[480px] bg-white rounded">
                <div class="w-full px-4 py-4 text-blue-700 text-md font-semibold border-b-gray-200 border-b-2">{{ dialog.title }}</div>
                <div class="w-full px-4 py-8 text-gray-600 text-md font-normal border-b-gray-200 border-b-2">{{ dialog.text }}</div>
                <div class="w-full px-4 py-2 flex justify-end items-center space-x-4">
                    <button @click="$emit('yes')" class="px-4 py-2 rounded bg-red-700 text-md text-semibold text-white hover:bg-red-600 active:bg-red-800"><span>Bəli</span></button>
                    <button @click="$emit('close')" class="px-4 py-2 rounded bg-gray-400 text-md text-semibold text-gray-800 hover:bg-gray-300 active:bg-gray-500"><span>Xeyr</span></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';

export default defineComponent ({
    name: "DialogComponent",
    props: [
        'dialog',
    ],
    setup(props) {
        // Properties
        const dialog = ref(props.dialog);

        return {
            dialog,
        }
    },
})
</script>
