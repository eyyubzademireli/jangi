<template>
    <div class="w-full 2xl:h-[55rem] bg-transparent xl:min-h-[46rem] lg:min-h-[40rem] md:min-h-[36rem] sm:min-h-[32rem] overflow-hidden flex flex-col justify-start items-center select-none 2xl:px-16 2xl:py-4 xl:px-16 xl:py-4 lg:px-10 lg:py-4 md:px-6 md:py-2 sm:px-4 sm:py-2">

        <!-- Head text starts -->
            <div class="w-full flex justify-center items-center text-gray-900 font-[900] mt-24 2xl:text-4xl">
                <span>HAQQIMIZDA</span>
            </div>
        <!-- Head text ends -->

        <div class="w-full flex flex-col justify-center items-center mt-10 space-y-4">
            <div class="2xl:w-[72rem] h-[20rem] flex justify-between items-start">
                <div class="2xl:w-[35rem] h-full flex justify-center items-center text-center">
                    <img class="2xl:w-[30rem] h-full object-contain" :src="abouts[0].image">
                </div>
                <div class="w-[35rem] h-full text-justify">
                    <span class="text-gray-900 2xl:text-xl text-justify">{{ abouts[0].description }}</span>
                </div>
            </div>

            <div class="2xl:w-[72rem] h-[20rem] flex justify-between items-start">
                <div class="w-[35rem] h-full text-justify">
                    <span class="text-gray-900 2xl:text-xl text-justify">{{ abouts[1].description }}</span>
                </div>
                <div class="2xl:w-[35rem] h-full flex justify-center items-center text-center">
                    <img class="2xl:w-[34rem] h-full object-contain grayscale hover:grayscale-0" :src="abouts[1].image">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent ({
    name: "AboutComponent",
    props: [
        'abouts',
    ],
    setup(props) {
        // Properties
        const abouts = props.abouts;
        // Methods

        // Computeds

        return {
            // Properties
            abouts

            // Methods

        }
    }
})
</script>
