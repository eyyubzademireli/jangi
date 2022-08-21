<template>
    <div class="w-full 2xl:h-[55rem] bg-transparent xl:min-h-[46rem] lg:min-h-[40rem] md:min-h-[36rem] sm:min-h-[32rem] overflow-hidden flex flex-col justify-start items-center select-none 2xl:px-16 2xl:py-4 xl:px-16 xl:py-4 lg:px-10 lg:py-4 md:px-6 md:py-2 sm:px-4 sm:py-2">
        <!-- Head text starts -->
            <div class="w-full flex justify-center items-center text-gray-900 font-[900] mt-24 2xl:text-4xl">
                <span>MÜKAFATLAR</span>
            </div>
        <!-- Head text ends -->

        <!-- Team starts -->
            <!-- Musicians start -->
                <div class="w-full flex justify-center items-center mt-14 animate__animated animate__fadeInUp animate__faster">
                    <swiper wrapperTag="div" tag="div" :pagination="pagination" :modules="modules" class="mySwiper flex flex-wrap justify-center items-center gap-x-4 gap-y-8 2xl:w-[72rem]">
                        <swiper-slide class="flex flex-wrap justify-start items-start gap-x-4 gap-y-8 w-[48rem] pb-20" v-for="item in awards" :key="item.id">
                            <div class="w-full flex space-x-4 justify-between items-center">
                                <div class="w-[49%] h-full">
                                    <img class="w-full h-[32rem] object-cover" :src="item.image">
                                </div>
                                <div class="w-[49%] h-full flex flex-col space-y-4">
                                    <span class="font-bold text-2xl">{{ item.title }}</span>
                                    <span>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Cum, nihil? Eius perspiciatis vero atque, natus laborum dolore sit enim, fugit accusamus quisquam aut fugiat quia quis ipsum distinctio amet! Ducimus.</span>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            <!-- Musicians end -->
        <!-- Team ends -->
    </div>
</template>


<style>
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

import "swiper/css";
import "swiper/css/pagination";

export default defineComponent ({
    name: "AwardsComponent",
    components: {
      Swiper,
      SwiperSlide,
    },
    props: [
        'awards',
    ],
    setup(props) {
        // Properties
        const awards = props.awards;

        // Methods

        return {
            // Properties
            awards,

            // Methods

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
