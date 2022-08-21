<template>
    <div class="w-full 2xl:min-h-[50rem] xl:min-h-[46rem] lg:min-h-[40rem] md:min-h-[36rem] sm:min-h-[32rem] h-screen bg-transparent overflow-hidden flex flex-col justify-between items-center select-none 2xl:px-16 2xl:py-4 xl:px-16 xl:py-4 lg:px-10 lg:py-4 md:px-6 md:py-2 sm:px-4 sm:py-2">
        <!-- Header starts -->
            <!-- Fixed starts -->
                <div class="w-full h-20 fixed z-[60] top-0 2xl:px-16 xl:px-16 lg:px-10 md:px-6 sm:px-4 bg-white flex justify-between items-center" :class="{'shadow-md': scrolled}">
                    <!-- Logo starts -->
                        <div class="px-4 h-14 flex justify-center items-center">
                            <img @click="goTo('welcome')" class="cursor-pointer w-full h-[5rem] relative" src="/storage/images/brush.png" alt="">
                        </div>
                    <!-- Logo ends -->

                    <!-- Menu starts -->
                        <div class="w-full md:hidden sm:hidden h-[4.5rem] 2xl:flex xl:flex lg:flex items-center justify-end space-x-4 py-1">
                            <div @click="goTo(item.tag)" class="h-full flex justify-center items-center cursor-pointer border-b-2 hover:box-border box-border border-b-transparent hover:border-b-red-200 text-gray-900" v-for="item in menu" :key="item.tag">
                                <span class="2xl:text-xl xl:text-lg lg:text-base md:text-sm sm:text-[12px]">{{ item.text }}</span>
                            </div>
                        </div>

                        <div @click="openMenu" class="2xl:hidden xl:hidden lg:hidden hidden sm:flex md:flex h-[4.5rem] items-center justify-end text-3xl text-gray-700 cursor-pointer">
                            <i class="fa-solid fa-bars"></i>
                        </div>
                    <!-- Menu ends -->
                </div>
            <!-- Fixed ends -->

            <div class="w-full h-14"></div>

            <div v-if="menuStatus" class="animate__animated animate__bounceIn animate__faster bg-white w-full h-full fixed z-50 top-0 left-0 flex flex-col space-y-4 justify-center items-center px-4">
                <div @click="goTo(item.tag)" class="flex justify-center items-center cursor-pointer w-full py-4 border-2 border-gray-300 shadow-md rounded text-gray-900" v-for="item in menu" :key="item.tag">
                    <span class="text-4xl font-[600]">{{ item.text }}</span>
                </div>
            </div>
        <!-- Header ends -->

        <!-- Content starts -->
            <div class="w-full flex justify-center items-center">
                <span class="text-gray-900 2xl:text-[22rem] xl:text-[16rem] lg:text-[12rem] md:text-[10rem] sm:text-[8rem] brush 2xl:-mt-60 xl:-mt-52 lg:-mt-48 md:-mt-40 sm:-mt-36">JANGI</span>
            </div>
        <!-- Content ends -->

        <!-- Footer starts -->
            <div class="w-full h-14 flex justify-between items-center">
                <div class="flex space-x-4 items-center">
                    <i class="fa-solid fa-copyright"></i>
                    <span class="2xl:text-xl xl:text-lg lg:text-base md:text-sm sm:text-[12px] text-gray-900 font-[400]">Bütün hüquqlar qorunur</span>
                </div>

                <div @click="goTo('team')" class="flex space-x-4 items-center cursor-pointer animate-bounce">
                    <i class="2xl:text-xl xl:text-lg lg:text-md md:text-sm sm:text-[12px] fa-solid fa-angles-down text-red-500"></i>
                    <span class="text-gray-900 2xl:text-xl xl:text-lg lg:text-base md:text-sm sm:text-[12px]">Aşağı sürüşdür</span>
                </div>

                <div class="flex items-center space-x-4 2xl:text-2xl xl:text-xl lg:text-base md:text-sm sm:text-[12px">
                    <a :href="info.facebook" target="_blank" class="text-gray-900 cursor-pointer hover:text-slate-900"><i class="fa-brands fa-facebook-square"></i></a>
                    <a :href="info.instagram" target="_blank" class="text-gray-900 cursor-pointer hover:text-slate-900"><i class="fa-brands fa-instagram-square"></i></a>
                    <a :href="info.youtube" target="_blank" class="text-gray-900 cursor-pointer hover:text-slate-900"><i class="fa-brands fa-youtube"></i></a>
                <a :href="'mailto:'+info.email" target="_blank" class="text-gray-900 cursor-pointer hover:text-slate-900"><i class="fa-solid fa-envelope"></i></a>
                </div>
            </div>
        <!-- Footer ends -->
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import 'animate.css';

export default defineComponent ({
    name: "WelcomeComponent",
    props: [
        'scrolled',
        'info'
    ],
    setup(props, context) {
        // Properties
        const menu = [
            { tag: 'welcome', text: 'Əsas səhifə' },
            { tag: 'team', text: 'Komandamız' },
            { tag: 'about', text: 'Haqqımızda' },
            { tag: 'awards', text: 'Mükafatlar' },
            { tag: 'events', text: 'Tədbirlər' },
            { tag: 'media', text: 'Media' },
            { tag: 'contacts', text: 'Əlaqə' }
        ];
        let menuStatus = ref(false);
        let info = props.info;

        // Methods
        const goTo = (tag) => {
            menuStatus.value = false;
            context.emit('currentPage', tag);
        }

        const openMenu = () => {
            menuStatus.value = !menuStatus.value;
        }

        return {
            // Properties
            menu,
            menuStatus,
            info,

            // Methods
            goTo,
            openMenu
        }
    }
})
</script>
