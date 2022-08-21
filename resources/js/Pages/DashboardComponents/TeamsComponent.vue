<template>
    <div class="w-full h-full flex flex-col min-h-[560px] select-none px-2">
        <!-- Head text starts -->
            <div class="w-full flex pt-2 mb-4 text-gray-500 font-[900] text-4xl">
                <span>KOMANDAMIZ</span>
            </div>
        <!-- Head text ends -->

        <!-- Dialog Component starts -->
        <dialog-component v-if="dialogShow" :dialog="dialog" @yes="remove" @close="dialogShow = false" />
        <alert-component v-if="alertShow" :dialog="alert" />
        <!-- Dialog Component ends -->

        <!-- Info starts -->
            <!-- Table starts -->
            <div class="w-full flex flex-col space-y-6 mt-10" v-if="view == 'table'">
                <div class="w-full h-12 flex justify-between items-center">
                    <div class="w-full flex justify-start items-center space-x-4">
                        <input class="rounded h-8 w-96" type="text" v-model.trim="searchText" placeholder="Axtar...">
                        <button @click="searchText = ''" v-if="searchText != ''" class="rounded h-8 px-4 flex justify-center items-center text-gray-500 bg-gray-200"><i class="fas fa-times"></i></button>
                    </div>
                    <button @click="openAdd" class="w-48 h-8 px-4 flex space-x-4 justify-center items-center bg-green-500 text-white text-md font-semibold rounded hover:bg-green-400 active:bg-green-600 shadow-md">
                        <i class="fas fa-plus"></i>
                        <span>Üzv əlavə et</span>
                    </button>
                </div>

                <div v-if="(teams.length == 0 && searchText == '') || (searchResult.length == 0 && searchText != '')" class="w-full h-48 flex justify-center items-center shadow-md bg-gray-100 rounded text-md font-semibold text-gray-700">
                    <span>Heç bir komanda üzvü tapılmadı</span>
                </div>
                <div v-if="(teams.length != 0 && searchText == '') || (searchResult.length != 0 && searchText != '')" class="w-full h-12 flex justify-start items-center px-4 shadow-md bg-gray-100 rounded text-md font-semibold text-gray-700">
                    <div class="w-full"><span>Şəkil:</span></div>
                    <div class="w-full"><span>Ad:</span></div>
                    <div class="w-full"><span>Soyad:</span></div>
                    <div class="w-full"><span>İxtisas:</span></div>
                    <div class="w-full"><span>Kateqoriya:</span></div>
                    <div class="w-full"><span>Əməliyyatlar:</span></div>
                </div>
                <div class="w-full flex flex-col space-y-2"  v-if="searchText == ''">
                    <div v-for="member in paginatedData" :key="member.id" class="w-full h-12 flex justify-start items-center px-4 shadow-md bg-gray-100 rounded text-md font-semibold text-gray-700">
                        <div class="w-full"><img :src="member.image" class="object-cover w-10 h-10" alt=""></div>
                        <div class="w-full truncate"><span>{{ member.name }}</span></div>
                        <div class="w-full truncate"><span>{{ member.surname }}</span></div>
                        <div class="w-full truncate"><span>{{ member.category }}</span></div>
                        <div class="w-full truncate"><span>{{ member.group }}</span></div>
                        <div class="w-full flex justify-center space-x-6">
                            <i @click="showDialog(member.id)" class="fas fa-trash text-red-700 cursor-pointer"></i>
                            <i @click="getMember(member)" class="fas fa-pen text-green-500 cursor-pointer"></i>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col space-y-2"  v-if="searchText != ''">
                    <div v-for="member in paginatedData" :key="member.id" class="w-full h-12 flex justify-start items-center px-4 shadow-md bg-gray-100 rounded text-md font-semibold text-gray-700">
                        <div class="w-full"><img :src="member.image" class="object-cover w-10 h-10" alt=""></div>
                        <div class="w-full truncate"><span>{{ member.name }}</span></div>
                        <div class="w-full truncate"><span>{{ member.surname }}</span></div>
                        <div class="w-full truncate"><span>{{ member.category }}</span></div>
                        <div class="w-full truncate"><span>{{ member.group }}</span></div>
                        <div class="w-full flex justify-center space-x-6">
                            <i @click="showDialog(member.id)" class="fas fa-trash text-red-700 cursor-pointer"></i>
                            <i @click="getMember(member)" class="fas fa-pen text-green-500 cursor-pointer"></i>
                        </div>
                    </div>
                </div>
                <paginate
                    :page-count="pageCount"
                    :prev-text="'Geri'"
                    :next-text="'İrəli'"
                    v-model="currentPage"
                    :page-range="3"
                    :margin-pages="2"
                    :click-handler="goToPage"
                    :container-class="'pagination'"
                    :page-class="'page-item'"
                    >
                </paginate>
            </div>
            <!-- Table ends -->

            <!-- Add form starts -->
            <div class="w-full flex flex-col space-y-6 mt-10" v-if="view == 'add'">
                <div @click="openFile" class="w-full h-24 flex justify-center items-center text-gray-500 border-2 border-gray-500 rounded border-dashed cursor-pointer hover:border-blue-500 hover:text-blue-500 transition-all text-xl font-bold">
                    <input id="file" hidden type="file" accept="image/*" @change="onFileChanged($event)">
                    <span v-if="imageLink == null">Şəkli yükləmək üçün klikləyin</span>
                    <span v-else>Yüklənmiş şəkli dəyişmək üçün klikləyin</span>
                </div>
                <div class="w-full flex space-x-4">
                    <input class="rounded w-full" v-model="name" type="text" placeholder="Ad">
                    <input class="rounded w-full" v-model="surname" type="text" placeholder="Soyad">
                </div>
                <div class="w-full flex space-x-4">
                    <input class="rounded w-full" v-model="category" type="text" placeholder="İxtisas">
                    <div class="w-full rounded bg-gray-300 flex p-2 space-x-2">
                        <button @click="group = 'music'" :class="{'cursor-pointer hover:bg-gray-100 active:bg-gray-200 w-full bg-white text-md text-gray-600 rounded-l py-1 flex justify-center items-center': group == 'music', 'cursor-pointer hover:bg-white active:bg-gray-200 w-full bg-transparent text-md text-gray-600 rounded-l py-2 flex justify-center items-center': group !== 'music'}">
                            <span>Musiqi</span>
                        </button>
                        <button @click="group = 'dance'" :class="{'cursor-pointer hover:bg-gray-100 active:bg-gray-200 w-full bg-white text-md text-gray-600 rounded-r py-1 flex justify-center items-center': group == 'dance', 'cursor-pointer hover:bg-white active:bg-gray-200 w-full bg-transparent text-md text-gray-600 rounded-r py-2 flex justify-center items-center': group !== 'dance'}">
                            <span>Rəqs</span>
                        </button>
                    </div>
                </div>
                <div class="w-full flex justify-end items-center space-x-4">
                    <button @click="create" class="px-10 py-2 text-white text-md font-semibold bg-green-500 hover:bg-green-400 active:bg-green-600 cursor-pointer flex justify-center items-center rounded"><span>Əlavə et</span></button>
                    <button @click="closeAdd" class="px-10 py-2 text-gray-700 text-md font-semibold bg-gray-300 hover:bg-gray-200 active:bg-gray-400 cursor-pointer flex justify-center items-center rounded"><span>Bağla</span></button>
                </div>
            </div>
            <!-- Add form ends -->

            <!-- Edit form starts -->
            <div class="w-full flex flex-col space-y-6 mt-10" v-if="view == 'edit'">
                <div class="w-full flex space-x-4 justify-start items-start">
                    <div>
                        <img :src="imageLink" class="w-24 h-24 rounded object-cover" alt="">
                    </div>
                    <div @click="openFile" class="w-full h-24 flex justify-center items-center text-gray-500 border-2 border-gray-500 rounded border-dashed cursor-pointer hover:border-blue-500 hover:text-blue-500 transition-all text-xl font-bold">
                        <input id="file" hidden type="file" accept="image/*" @change="onFileChanged($event)">
                        <span v-if="imageLink == null">Şəkli yükləmək üçün klikləyin</span>
                        <span v-else>Yüklənmiş şəkli dəyişmək üçün klikləyin</span>
                    </div>
                </div>
                <div class="w-full flex space-x-4">
                    <input class="rounded w-full" v-model="name" type="text" placeholder="Ad">
                    <input class="rounded w-full" v-model="surname" type="text" placeholder="Soyad">
                </div>
                <div class="w-full flex space-x-4">
                    <input class="rounded w-full" v-model="category" type="text" placeholder="İxtisas">
                    <div class="w-full rounded bg-gray-300 flex p-2 space-x-2">
                        <button @click="group = 'music'" :class="{'cursor-pointer hover:bg-gray-100 active:bg-gray-200 w-full bg-white text-md text-gray-600 rounded-l py-1 flex justify-center items-center': group == 'music', 'cursor-pointer hover:bg-white active:bg-gray-200 w-full bg-transparent text-md text-gray-600 rounded-l py-2 flex justify-center items-center': group !== 'music'}">
                            <span>Musiqi</span>
                        </button>
                        <button @click="group = 'dance'" :class="{'cursor-pointer hover:bg-gray-100 active:bg-gray-200 w-full bg-white text-md text-gray-600 rounded-r py-1 flex justify-center items-center': group == 'dance', 'cursor-pointer hover:bg-white active:bg-gray-200 w-full bg-transparent text-md text-gray-600 rounded-r py-2 flex justify-center items-center': group !== 'dance'}">
                            <span>Rəqs</span>
                        </button>
                    </div>
                </div>
                <div class="w-full flex justify-end items-center space-x-4">
                    <button @click="update" class="px-10 py-2 text-white text-md font-semibold bg-green-500 hover:bg-green-400 active:bg-green-600 cursor-pointer flex justify-center items-center rounded"><span>Yadda saxla</span></button>
                    <button @click="closeEdit" class="px-10 py-2 text-gray-700 text-md font-semibold bg-gray-300 hover:bg-gray-200 active:bg-gray-400 cursor-pointer flex justify-center items-center rounded"><span>Bağla</span></button>
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
import { defineComponent, onMounted, ref, watch } from 'vue';
import Paginate from 'vuejs-paginate-next';

import DialogComponent from './DialogComponent.vue'
import AlertComponent from './AlertComponent.vue'

export default defineComponent ({
    name: "TeamsComponent",
    components: {
        DialogComponent,
        AlertComponent,
        paginate: Paginate,
    },
    props: [
        'teams',
    ],
    setup(props) {
        // Properties
        const teams = ref(props.teams);
        let searchText = ref('');
        let searchResult = ref([]);
        let dialogShow = ref(false);
        let alertShow = ref(false);
        let currentMember = ref(null);
        let paginatedData = ref([]);
        let currentPage = ref(1);
        let pageCount = ref(1);
        let file = ref(null);
        let imageLink = ref(null);
        let view = ref('table'); // add, edit, table
        let name = ref('');
        let surname = ref('');
        let category = ref('');
        let group = ref('music');
        let currentMemberEdit = ref(null);
        let disabled = ref(false);
        const dialog = {
            title: 'Komanda üzvünün ləğv edilməsi',
            text: 'Komanda üzvünü ləğv etmək istədiyinizə əminsiniz?',
        }
        let alert = ref({
            title: '',
            text: '',
        });

        const search = () => {
            if(searchText.value == '') {
                currentPage.value = 1;
                searchResult.value = [];
            } else {
                currentPage.value = 1;
                searchResult.value = teams.value.filter(team => {
                    if (team.name.toLowerCase().includes(searchText.value.toLowerCase()) || team.surname.toLowerCase().includes(searchText.value.toLowerCase())) {
                        return team;
                    }
                });
            }
            paginate();
        }

        const showDialog = (id) => {
            currentMember.value = id;
            dialogShow.value = true;
        }

        const paginate = () => {
            if(searchText.value != '') {
                pageCount.value = Math.ceil(searchResult.value.length / 5);
                paginatedData.value = searchResult.value.slice((currentPage.value - 1) * 5, currentPage.value * 5);
            } else {
                pageCount.value = Math.ceil(teams.value.length / 5);
                paginatedData.value = teams.value.slice((currentPage.value - 1) * 5, currentPage.value * 5);
            }
        }

        const goToPage = (pageNum) => {
            currentPage.value = pageNum;
            paginate();
        }

        const showAlert = (title, text) => {
            alert.value.title = title;
            alert.value.text = text;
            alertShow.value = true;
            setTimeout(() => {
                alertShow.value = false;
            }, 2000);
        }

        const remove = () => {
            axios.post('/composer/teams/remove', {
                member: currentMember.value,
            })
            .then(function (response) {
                if(response.data.success == true) {
                    dialogShow.value = false;
                    currentMember.value = null;
                    showAlert('Təbriklər', 'Komanda üzvü uğurla ləğv edildi');
                    teams.value = response.data.teams;
                    paginate();
                }else {
                    dialogShow.value = false;
                    currentMember.value = null;
                    showAlert('Xəta', 'Komanda üzvünü ləğv etmək mümkün olmadı');
                }
            })
            .catch(function (error) {
                dialogShow.value = false;
                currentMember.value = null;
                showAlert('Xəta', 'Komanda üzvünü ləğv etmək mümkün olmadı');
            })
        }

        const openAdd = () => {
            view.value = 'add';
        }

        const closeAdd = () => {
            name.value = '';
            surname.value = '';
            category.value = '';
            group.value = 'music';
            file.value = null;
            imageLink.value = null;
            document.getElementById('file').value = "";
            view.value = 'table';
        }

        const getMember = (member) => {
            view.value = 'edit';
            currentMemberEdit.value = member;
            name.value = member.name;
            surname.value = member.surname;
            category.value = member.category;
            group.value = member.group;
            file.value = null;
            imageLink.value = member.image;
        }

        const closeEdit = () => {
            currentMemberEdit.value = null;
            name.value = '';
            surname.value = '';
            category.value = '';
            group.value = 'music';
            file.value = null;
            imageLink.value = null;
            document.getElementById('file').value = "";
            view.value = 'table';
        }

        watch(searchText, async (n, o) => {
            if(n !== o) {
                search();
            }
        })

        onMounted(() => {
            paginate();
        })

        const openFile = () => {
            imageLink.value = null;
            file.value = null;
            document.getElementById('file').value = "";
            document.getElementById('file').click();
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

        const create = () => {
            axios.post('/composer/teams/add', {
                name: name.value,
                surname: surname.value,
                image: imageLink.value,
                group: group.value,
                category: category.value,
            }).then(function (response) {
                if(response.data.success == true) {
                    showAlert('Təbriklər', 'Yeni komanda üzvü uğurla əlavə edildi');
                    teams.value = response.data.teams;
                    paginate();
                    view.value = 'table';
                }else {
                    showAlert('Xəta', 'Komanda üzvü əlavə edilə bilmədi');
                }
            }).catch(function (error) {
                showAlert('Xəta', 'Komanda üzvü əlavə edilə bilmədi');
            })
        }

        const update = () => {
            disabled.value = true;
            axios.post('/composer/teams/update', {
                id: currentMemberEdit.value.id,
                name: name.value,
                surname: surname.value,
                image: imageLink.value,
                group: group.value,
                category: category.value,
            }).then(function (response) {
                if(response.data.success == true) {
                    showAlert('Təbriklər', 'Komanda üzvü uğurla redaktə edildi');
                    teams.value = response.data.teams;
                    paginate();
                    view.value = 'table';
                }else {
                    showAlert('Xəta', 'Komanda üzvü redaktə edilə bilmədi');
                }
                disabled.value = false;
            }).catch(function (error) {
                showAlert('Xəta', 'Komanda üzvü redaktə edilə bilmədi');
                disabled.value = false;
            })
        }

        return {
            teams,
            searchText,
            searchResult,
            remove,
            dialog,
            dialogShow,
            showDialog,
            currentMember,
            alertShow,
            alert,
            paginatedData,
            currentPage,
            pageCount,
            goToPage,
            view,
            openAdd,
            openFile,
            onFileChanged,
            imageLink,
            closeAdd,
            create,
            name,
            surname,
            category,
            group,
            currentMemberEdit,
            closeEdit,
            getMember,
            disabled,
            update,
        }
    },
})
</script>
