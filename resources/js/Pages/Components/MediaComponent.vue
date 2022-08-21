<template>
    <div class="w-full 2xl:h-[55rem] bg-transparent xl:min-h-[46rem] lg:min-h-[40rem] md:min-h-[36rem] sm:min-h-[32rem] overflow-hidden flex flex-col justify-start items-center select-none 2xl:px-16 2xl:py-4 xl:px-16 xl:py-4 lg:px-10 lg:py-4 md:px-6 md:py-2 sm:px-4 sm:py-2">
        <!-- Head text starts -->
            <div class="w-full flex justify-center items-center text-gray-900 font-[900] mt-24 2xl:text-4xl">
                <span>MEDİA</span>
            </div>
        <!-- Head text ends -->

        <!-- Tab starts -->
            <div class="w-full mt-10 flex justify-center items-center">
                <div class="w-auto flex justify-center items-center border-4 border-gray-900">
                    <div @click="changeGroup('music')" class="py-2 px-14 font-[600] cursor-pointer" :class="{'bg-white text-gray-900': group != 'music', 'bg-gray-900 text-white': group == 'music'}"><span>MUSİQİ QRUPU</span></div>
                    <div @click="changeGroup('dance')" class="py-2 px-14 font-[600] cursor-pointer" :class="{'bg-white text-gray-900': group != 'dance', 'bg-gray-900 text-white': group == 'dance'}"><span>RƏQS QRUPU</span></div>
                </div>
            </div>
        <!-- Tab ends -->

        <!-- Team starts -->
            <!-- Musicians start -->
                <div v-if="group == 'music'" class="w-full flex justify-center items-center mt-14 animate__animated animate__fadeInUp animate__faster">
                    <swiper wrapperTag="div" tag="div" :pagination="pagination" :modules="modules" class="mySwiper flex flex-wrap justify-center items-center gap-x-4 gap-y-8 2xl:w-[72rem]">
                        <swiper-slide class="flex flex-wrap justify-start items-start gap-x-4 gap-y-8 w-[48rem] pb-20" v-for="musicians in musiciansArray" :key="musicians.id">
                            <lightgallery class="flex flex-wrap justify-start items-start gap-x-4 gap-y-8">
                                <a :href="item.image" class="w-44 overflow-x-hidden flex flex-col space-y-1 cursor-pointer hover:shadow-md" v-for="item in musicians[0]" :key="item.id">
                                    <img class="mx-auto pt-2 w-40 h-44 object-cover grayscale hover:grayscale-0" :src="item.image">
                                </a>
                            </lightgallery>
                        </swiper-slide>
                    </swiper>
                </div>
            <!-- Musicians end -->

            <!-- Dancers start -->
                <div v-if="group == 'dance'" class="w-full flex justify-center items-center mt-14 animate__animated animate__fadeInUp animate__faster">
                    <swiper wrapperTag="div" tag="div" :pagination="pagination" :modules="modules" class="mySwiper flex flex-wrap justify-center items-center gap-x-4 gap-y-8 2xl:w-[72rem]">
                        <swiper-slide class="flex flex-wrap justify-start items-start gap-x-4 gap-y-8 w-[48rem] pb-20" v-for="dancers in dancersArray" :key="dancers.id">
                            <lightgallery class="flex flex-wrap justify-start items-start gap-x-4 gap-y-8">
                                <a :href="item.image" class="w-44 overflow-x-hidden flex flex-col space-y-1 cursor-pointer hover:shadow-md" v-for="item in dancers[0]" :key="item.id">
                                    <img class="mx-auto pt-2 w-40 h-44 object-cover grayscale hover:grayscale-0" :src="item.image">
                                </a>
                            </lightgallery>
                        </swiper-slide>
                    </swiper>
                </div>
            <!-- Dancers end -->
        <!-- Team ends -->
    </div>
</template>


<style>
    @import 'lightgallery/css/lightgallery.css';

    .swiper-pagination-bullet {
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        font-size: 14px;
        color: #0f172a;
        opacity: 1;
        background: #e2e8f0;
    }

    .swiper-pagination-bullet-active {
        color: #fff;
        background: #0f172a;
    }
</style>

<script>
import { defineComponent, ref, computed } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination } from "swiper";

import Lightgallery from 'lightgallery/vue';

import "swiper/css";
import "swiper/css/pagination";

export default defineComponent ({
    name: "MediaComponent",
    components: {
      Swiper,
      SwiperSlide,
      Lightgallery,
    },
    props: [
        'media'
    ],
    setup(props) {
        // Properties
        let group = ref('music');
        let media = props.media;

        const musicians = media.filter(item => item.group == 'music');

        const dancers = media.filter(item => item.group === 'dance');

        // Methods
        const changeGroup = (tag) => {
            group.value = tag;
        }

        // Computeds
        const musiciansArray = computed(() => {
            const pagesCount = Math.ceil(musicians.length / 12);
            const pages = [];
            for (let i = 0; i < pagesCount; i++) {
                pages.push([]);
            }
            for (let index = 0; index < pagesCount; index++) {
                pages[index].push(musicians.slice(index * 12, (index + 1) * 12));
            }
            return pages;
        });

        const dancersArray = computed(() => {
            const pagesCount = Math.ceil(dancers.length / 12);
            const pages = [];
            for (let i = 0; i < pagesCount; i++) {
                pages.push([]);
            }
            for (let index = 0; index < pagesCount; index++) {
                pages[index].push(dancers.slice(index * 12, (index + 1) * 12));
            }
            return pages;
        });

        return {
            // Properties
            group,
            musiciansArray,
            dancersArray,

            // Methods
            changeGroup,

            // Components
            pagination: {
                clickable: true,
                renderBullet: function (index, className) {
                return '<span class="' + className + '">' + (index + 1) + "</span>";
                },
            },
            modules: [Pagination],
        }
    }
})
</script>
