<template>
    <div class="w-full h-full flex flex-col min-h-[560px] select-none px-2">
        <!-- Head text starts -->
            <div class="w-full flex pt-2 mb-4 text-gray-500 font-[900] text-4xl">
                <span>MƏLUMATLAR</span>
            </div>
        <!-- Head text ends -->

        <!-- Info starts -->
            <div class="w-full flex flex-col space-y-4 mt-10">
                <div class="w-full flex space-x-6 justify-start items-start">
                    <input v-model="info.mobile" class="w-full rounded text-md" type="text" placeholder="Mobil nömrə">
                    <input  v-model="info.phone" class="w-full rounded text-md" type="text" placeholder="Ofis nömrə">
                    <input  v-model="info.whatsapp" class="w-full rounded text-md" type="text" placeholder="Whatsapp nömrə">
                </div>
                <div class="w-full flex space-x-6 justify-start items-start">
                    <input  v-model="info.facebook" class="w-full rounded text-md" type="text" placeholder="Facebook">
                    <input  v-model="info.instagram" class="w-full rounded text-md" type="text" placeholder="Instagram">
                </div>
                <div class="w-full flex space-x-6 justify-start items-start">
                    <input  v-model="info.youtube" class="w-full rounded text-md" type="text" placeholder="Youtube">
                    <input  v-model="info.email" class="w-full rounded text-md" type="text" placeholder="Email">
                </div>
                <div class="w-full flex space-x-6 justify-start items-start">
                    <input  v-model="info.address" class="w-full rounded text-md" type="text" placeholder="Ünvan">
                    <button @click="send" class="w-full rounded text-md space-x-4 flex justify-center items-center bg-green-600 hover:bg-green-500 active:bg-green-700 text-white cursor-pointer py-2"><i class="fa-solid fa-floppy-disk"></i><span>Yadda saxla</span></button>
                </div>
            </div>
        <!-- Info ends -->
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';

export default defineComponent ({
    name: "InfoComponent",
    props: [
        'info',
    ],
    setup(props) {
        // Properties
        const info = ref(props.info[0]);

        const send = () => {
            axios.post('/composer/info', {
                info: info.value,
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        return {
            info,
            send,
        }
    },
})
</script>
