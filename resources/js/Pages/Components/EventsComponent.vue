<template>
    <div class="w-full 2xl:h-[55rem] bg-transparent xl:min-h-[46rem] lg:min-h-[40rem] md:min-h-[36rem] sm:min-h-[32rem] overflow-hidden flex flex-col justify-start items-center select-none 2xl:px-16 2xl:py-4 xl:px-16 xl:py-4 lg:px-10 lg:py-4 md:px-6 md:py-2 sm:px-4 sm:py-2">
        <!-- Head text starts -->
            <div class="w-full flex justify-center items-center text-gray-900 font-[900] mt-24 2xl:text-4xl">
                <span>TƏDBİRLƏR</span>
            </div>
        <!-- Head text ends -->

        <!-- Tab starts -->
            <div class="w-full mt-10 flex justify-center items-center">
                <div class="w-auto flex justify-center items-center border-4 border-gray-900">
                    <div @click="changeGroup('music')" class="py-2 px-14 font-[600] cursor-pointer" :class="{'bg-white text-gray-900': group != 'music', 'bg-gray-900 text-white': group == 'music'}"><span>GƏLƏCƏK TƏDBİRLƏR</span></div>
                    <div @click="changeGroup('dance')" class="py-2 px-14 font-[600] cursor-pointer" :class="{'bg-white text-gray-900': group != 'dance', 'bg-gray-900 text-white': group == 'dance'}"><span>KEÇMİŞ TƏDBİRLƏR</span></div>
                </div>
            </div>
        <!-- Tab ends -->

        <!-- Team starts -->
            <!-- Musicians start -->
                <div v-if="group == 'music'" class="w-full flex justify-center items-center mt-14 animate__animated animate__fadeInUp animate__faster">
                    <swiper wrapperTag="div" tag="div" :pagination="pagination" :modules="modules" class="mySwiper flex flex-wrap justify-center items-center gap-x-4 gap-y-8 2xl:w-[72rem]">
                        <swiper-slide class="flex flex-col justify-center items-center space-y-2 w-full pb-20" v-for="musicians in musiciansArray" :key="musicians.id">
                            <div class="w-[75%] overflow-x-hidden flex cursor-pointer hover:shadow-md border-4 border-gray-900 p-2 h-28" v-for="item in musicians[0]" :key="item.id">
                                <div class="w-[85%] flex space-x-4 items-center">
                                    <div class="w-[15%] h-full flex flex-col space-y-2 bg-gray-900 justify-center items-center">
                                        <div class="text-3xl text-white font-black"><span>{{ item.day }}</span></div>
                                        <div class="text-base text-white font-[600]"><span>{{ item.month }}</span></div>
                                    </div>
                                    <div class="w-[85%] h-full flex flex-col space-y-2 justify-center items-center">
                                        <div class="truncate w-full text-2xl text-gray-900 font-[600]"><span>{{ item.name }}</span></div>
                                        <div class="truncate w-full text-base text-gray-900 flex space-x-4 items-center"><i class="fa-solid fa-location-dot"></i><span>{{ item.address }}</span></div>
                                    </div>
                                </div>
                                <div class="w-[15%] flex justify-center items-center">
                                    <a class="block text-center px-4 py-2 bg-gray-900 text-white text-lg font-[600]" :href="item.ticket_url" target="_blank"><span>Bilet al</span></a>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            <!-- Musicians end -->

            <!-- Dancers start -->
                <div v-if="group == 'dance'" class="w-full flex justify-center items-center mt-14 animate__animated animate__fadeInUp animate__faster">
                    <swiper wrapperTag="div" tag="div" :pagination="pagination" :modules="modules" class="mySwiper flex flex-wrap justify-center items-center gap-x-4 gap-y-8 2xl:w-[72rem]">
                        <swiper-slide class="flex flex-col justify-center items-center space-y-2 w-full pb-20" v-for="dancers in dancersArray" :key="dancers.id">
                            <div class="w-[75%] overflow-x-hidden flex cursor-pointer hover:shadow-md border-4 border-gray-900 p-2 h-28" v-for="item in dancers[0]" :key="item.id">
                                <div class="w-[85%] flex space-x-4 items-center">
                                    <div class="w-[15%] h-full flex flex-col space-y-2 bg-gray-900 justify-center items-center">
                                        <div class="text-3xl text-white font-black"><span>{{ item.day }}</span></div>
                                        <div class="text-base text-white font-[600]"><span>{{ item.month }}</span></div>
                                    </div>
                                    <div class="w-[85%] h-full flex flex-col space-y-2 justify-center items-center">
                                        <div class="truncate w-full text-2xl text-gray-900 font-[600]"><span>{{ item.name }}</span></div>
                                        <div class="truncate w-full text-base text-gray-900 flex space-x-4 items-center"><i class="fa-solid fa-location-dot"></i><span>{{ item.address }}</span></div>
                                    </div>
                                </div>
                                <div class="w-[15%] flex justify-center items-center">
                                    <a class="block text-center px-4 py-2 bg-gray-900 text-white text-lg font-[600]" :href="item.ticket_url" target="_blank"><span>Bilet al</span></a>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            <!-- Dancers end -->
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
    name: "TeamComponent",
    components: {
      Swiper,
      SwiperSlide,
    },
    props: [
        'events',
    ],
    setup(props) {
        // Properties
        let group = ref('music');
        let events = props.events;

        const musicians = events.filter(item => item.status == 'new');

        const dancers = events.filter(item => item.status == 'old');

        // Methods
        const changeGroup = (tag) => {
            group.value = tag;
        }

        // Computeds
        const musiciansArray = computed(() => {
            const pagesCount = Math.ceil(musicians.length / 4);
            const pages = [];
            for (let i = 0; i < pagesCount; i++) {
                pages.push([]);
            }
            for (let index = 0; index < pagesCount; index++) {
                pages[index].push(musicians.slice(index * 4, (index + 1) * 4));
            }
            return pages;
        });

        const dancersArray = computed(() => {
            const pagesCount = Math.ceil(dancers.length / 4);
            const pages = [];
            for (let i = 0; i < pagesCount; i++) {
                pages.push([]);
            }
            for (let index = 0; index < pagesCount; index++) {
                pages[index].push(dancers.slice(index * 4, (index + 1) * 4));
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
