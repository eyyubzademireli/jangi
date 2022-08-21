<template>
    <div class="w-full h-full flex flex-col min-h-[560px] select-none px-2">
        <!-- Head text starts -->
            <div class="w-full flex pt-2 mb-4 text-gray-500 font-[900] text-4xl">
                <span>HAQQIMIZDA</span>
            </div>
        <!-- Head text ends -->

        <!-- Dialog Component starts -->
        <alert-component v-if="alertShow" :dialog="alert" />
        <!-- Dialog Component ends -->

        <!-- Info starts -->
            <!-- Edit form starts -->
            <div class="w-full flex flex-col space-y-6 mt-10">
                <div class="w-full flex flex-col space-y-4">
                    <div class="w-full flex space-x-4">
                        <img :src="imageLink" class="w-60 h-64 rounded object-cover" alt="">
                        <textarea class="rounded w-full" v-model="description" name="description" id="" cols="30" rows="5" placeholder="Açıqlama"></textarea>
                    </div>
                    <div class="w-full flex space-x-4 justify-start items-start">
                        <div @click="openFile" class="w-full h-24 flex justify-center items-center text-gray-500 border-2 border-gray-500 rounded border-dashed cursor-pointer hover:border-blue-500 hover:text-blue-500 transition-all text-xl font-bold">
                            <input id="file" hidden type="file" accept="image/*" @change="onFileChanged($event)">
                            <span v-if="imageLink == null">Şəkli yükləmək üçün klikləyin</span>
                            <span v-else>Yüklənmiş şəkli dəyişmək üçün klikləyin</span>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col space-y-4 pt-4 border-t-2 border-gray-300">
                    <div class="w-full flex space-x-4">
                        <img :src="imageLink1" class="w-60 h-64 rounded object-cover" alt="">
                        <textarea class="rounded w-full" v-model="description1" name="description1" id="" cols="30" rows="5" placeholder="Açıqlama"></textarea>
                    </div>
                    <div class="w-full flex space-x-4 justify-start items-start">
                        <div @click="openFile1" class="w-full h-24 flex justify-center items-center text-gray-500 border-2 border-gray-500 rounded border-dashed cursor-pointer hover:border-blue-500 hover:text-blue-500 transition-all text-xl font-bold">
                            <input id="file1" hidden type="file" accept="image/*" @change="onFileChanged1($event)">
                            <span v-if="imageLink1 == null">Şəkli yükləmək üçün klikləyin</span>
                            <span v-else>Yüklənmiş şəkli dəyişmək üçün klikləyin</span>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end items-center space-x-4">
                    <button @click="update" class="px-10 py-2 text-white text-md font-semibold bg-green-500 hover:bg-green-400 active:bg-green-600 cursor-pointer flex justify-center items-center rounded"><span>Yadda saxla</span></button>
                </div>
            </div>
            <!-- Edit form ends -->
        <!-- Info ends -->
    </div>
</template>

<style lang="css">
.pagination {
	display: flex;
	padding-left: 0;
	list-style: none
}

.page-link {
	position: relative;
	display: block;
	color: #0d6efd;
	text-decoration: none;
	background-color: #fff;
	border: 1px solid #dee2e6;
	transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
	.page-link {
		transition: none
	}
}

.page-link:hover {
	z-index: 2;
	color: #0a58ca;
	background-color: #e9ecef;
	border-color: #dee2e6
}

.page-link:focus {
	z-index: 3;
	color: #0a58ca;
	background-color: #e9ecef;
	outline: 0;
	box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25)
}

.page-item:not(:first-child) .page-link {
	margin-left: -1px
}

.page-item.active .page-link {
	z-index: 3;
	color: #fff;
	background-color: #0d6efd;
	border-color: #0d6efd
}

.page-item.disabled .page-link {
	color: #6c757d;
	pointer-events: none;
	background-color: #fff;
	border-color: #dee2e6
}

.page-link {
	padding: .375rem .75rem
}

.page-item:first-child .page-link {
	border-top-left-radius: .25rem;
	border-bottom-left-radius: .25rem
}

.page-item:last-child .page-link {
	border-top-right-radius: .25rem;
	border-bottom-right-radius: .25rem
}

.pagination-lg .page-link {
	padding: .75rem 1.5rem;
	font-size: 1.25rem
}

.pagination-lg .page-item:first-child .page-link {
	border-top-left-radius: .3rem;
	border-bottom-left-radius: .3rem
}

.pagination-lg .page-item:last-child .page-link {
	border-top-right-radius: .3rem;
	border-bottom-right-radius: .3rem
}

.pagination-sm .page-link {
	padding: .25rem .5rem;
	font-size: .875rem
}

.pagination-sm .page-item:first-child .page-link {
	border-top-left-radius: .2rem;
	border-bottom-left-radius: .2rem
}

.pagination-sm .page-item:last-child .page-link {
	border-top-right-radius: .2rem;
	border-bottom-right-radius: .2rem
}
</style>

<script>
import { defineComponent, onMounted, ref } from 'vue';
import AlertComponent from './AlertComponent.vue'

export default defineComponent ({
    name: "AboutComponent",
    components: {
        AlertComponent,
    },
    props: [
        'about',
    ],
    setup(props) {
        // Properties
        const teams = ref(props.about);
        let alertShow = ref(false);
        let file = ref(null);
        let file1 = ref(null);
        let imageLink = ref(null);
        let imageLink1 = ref(null);
        let description = ref('');
        let description1 = ref('');
        let disabled = ref(false);
        let alert = ref({
            title: '',
            text: '',
        });

        const showAlert = (title, text) => {
            alert.value.title = title;
            alert.value.text = text;
            alertShow.value = true;
            setTimeout(() => {
                alertShow.value = false;
            }, 2000);
        }

        const innerUpdate = () => {
            imageLink.value = teams.value[0].image;
            description.value = teams.value[0].description;
            imageLink1.value = teams.value[1].image;
            description1.value = teams.value[1].description;
        }

        onMounted(() => {
            innerUpdate();
        })

        const openFile = () => {
            file.value = null;
            document.getElementById('file').value = "";
            document.getElementById('file').click();
        }

        const openFile1 = () => {
            file1.value = null;
            document.getElementById('file1').value = "";
            document.getElementById('file1').click();
        }

        const onFileChanged = ($event) => {
            const formData = new FormData();
            file.value = $event.target.files[0];
            formData.append('file', file.value);
            axios.post('/upload/photo', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function (response) {
                if(response.data.success == true) {
                    imageLink.value = response.data.image;
                }else {
                    showAlert('Xəta', 'Şəkil yüklənmədi');
                }
            }).catch(function (error) {
                showAlert('Xəta', 'Şəkil yüklənmədi, Yenidən yoxlayın');
            })
        }

        const onFileChanged1 = ($event) => {
            const formData = new FormData();
            file1.value = $event.target.files[0];
            formData.append('file', file1.value);
            axios.post('/upload/photo', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function (response) {
                if(response.data.success == true) {
                    imageLink1.value = response.data.image;
                }else {
                    showAlert('Xəta', 'Şəkil yüklənmədi');
                }
            }).catch(function (error) {
                showAlert('Xəta', 'Şəkil yüklənmədi, Yenidən yoxlayın');
            })
        }

        const update = () => {
            disabled.value = true;
            axios.post('/composer/about/update', {
                description: description.value,
                description1: description1.value,
                image: imageLink.value,
                image1: imageLink1.value,
            }).then(function (response) {
                if(response.data.success == true) {
                    showAlert('Təbriklər', 'Haqqımızda uğurla redaktə edildi');
                    teams.value = response.data.teams;
                    innerUpdate();
                }else {
                    showAlert('Xəta', 'Haqqımızda redaktə edilə bilmədi');
                }
                disabled.value = false;
            }).catch(function (error) {
                showAlert('Xəta', 'Haqqımızda redaktə edilə bilmədi');
                disabled.value = false;
            })
        }

        return {
            teams,
            alertShow,
            alert,
            file,
            file1,
            imageLink,
            disabled,
            update,
            description,
            description1,
            imageLink1,
            openFile,
            onFileChanged,
            onFileChanged1,
            openFile1,
        }
    },
})
</script>
