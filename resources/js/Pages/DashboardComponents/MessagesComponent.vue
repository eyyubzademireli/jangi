<template>
    <div class="w-full h-full flex flex-col min-h-[560px] select-none px-2">
        <!-- Head text starts -->
            <div class="w-full flex pt-2 mb-4 text-gray-500 font-[900] text-4xl">
                <span>İSMARICLAR</span>
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
                </div>

                <div v-if="(teams.length == 0 && searchText == '') || (searchResult.length == 0 && searchText != '')" class="w-full h-48 flex justify-center items-center shadow-md bg-gray-100 rounded text-md font-semibold text-gray-700">
                    <span>Heç bir ismarıc tapılmadı</span>
                </div>
                <div v-if="(teams.length != 0 && searchText == '') || (searchResult.length != 0 && searchText != '')" class="w-full h-12 flex justify-start items-center px-4 shadow-md bg-gray-100 rounded text-md font-semibold text-gray-700">
                    <div class="w-full"><span>Ad:</span></div>
                    <div class="w-full"><span>Soyad:</span></div>
                    <div class="w-full"><span>Email:</span></div>
                    <div class="w-full"><span>Əməliyyatlar:</span></div>
                </div>
                <div class="w-full flex flex-col space-y-2"  v-if="searchText == ''">
                    <div v-for="member in paginatedData" :key="member.id" class="w-full h-12 flex justify-start items-center px-4 shadow-md bg-gray-100 rounded text-md font-semibold text-gray-700">
                        <div class="w-full truncate"><span>{{ member.name }}</span></div>
                        <div class="w-full truncate"><span>{{ member.surname }}</span></div>
                        <div class="w-full truncate"><span>{{ member.email }}</span></div>
                        <div class="w-full flex justify-center space-x-6">
                            <i @click="showDialog(member.id)" class="fas fa-trash text-red-700 cursor-pointer"></i>
                            <i @click="openAdd(member)" class="fas fa-envelope-open text-green-500 cursor-pointer"></i>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col space-y-2"  v-if="searchText != ''">
                    <div v-for="member in paginatedData" :key="member.id" class="w-full h-12 flex justify-start items-center px-4 shadow-md bg-gray-100 rounded text-md font-semibold text-gray-700">
                        <div class="w-full truncate"><span>{{ member.name }}</span></div>
                        <div class="w-full truncate"><span>{{ member.surname }}</span></div>
                        <div class="w-full truncate"><span>{{ member.email }}</span></div>
                        <div class="w-full flex justify-center space-x-6">
                            <i @click="showDialog(member.id)" class="fas fa-trash text-red-700 cursor-pointer"></i>
                            <i @click="openAdd(member)" class="fas fa-envelope-open text-green-500 cursor-pointer"></i>
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
                <div class="w-full flex flex-col space-y-6 items-center justify-center">
                    <h1 class="font-semibold text-2xl">İSMARICIN MƏZMUNU</h1>
                    <div class="w-[50%] rounded shadow-md mx-auto bg-gray-200 px-4 py-4 flex flex-col space-y-4">
                        <div class="w-full flex justify-between pb-2 border-b-2 border-b-gray-400 mb-2">
                            <span class="font-semibold text-xl">AD:</span>
                            <span>{{ currentMember.name }}</span>
                        </div>
                        <div class="w-full flex justify-between pb-2 border-b-2 border-b-gray-400 mb-2">
                            <span class="font-semibold text-xl">SOYAD:</span>
                            <span>{{ currentMember.surname }}</span>
                        </div>
                        <div class="w-full flex justify-between pb-2 border-b-2 border-b-gray-400 mb-2">
                            <span class="font-semibold text-xl">EMAIL:</span>
                            <span>{{ currentMember.email }}</span>
                        </div>
                        <div class="w-full flex flex-col space-y-4 pb-2">
                            <span class="font-semibold text-xl">İSMARIC:</span>
                            <span>{{ currentMember.message }}</span>
                        </div>
                    </div>
                    <div class="w-[50%] mx-auto flex justify-end items-center space-x-4">
                        <button @click="removeInner" class="px-10 py-2 text-white text-md font-semibold bg-red-500 hover:bg-red-400 active:bg-red-600 cursor-pointer flex justify-center items-center rounded"><span>Sil</span></button>
                        <button @click="closeAdd" class="px-10 py-2 text-gray-700 text-md font-semibold bg-gray-300 hover:bg-gray-200 active:bg-gray-400 cursor-pointer flex justify-center items-center rounded"><span>Bağla</span></button>
                    </div>
                </div>
            </div>
            <!-- Add form ends -->
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
    name: "MessagesComponent",
    components: {
        DialogComponent,
        AlertComponent,
        paginate: Paginate,
    },
    props: [
        'messages',
    ],
    setup(props) {
        // Properties
        const teams = ref(props.messages);
        let searchText = ref('');
        let searchResult = ref([]);
        let dialogShow = ref(false);
        let alertShow = ref(false);
        let currentMember = ref(null);
        let paginatedData = ref([]);
        let currentPage = ref(1);
        let pageCount = ref(1);
        let view = ref('table'); // table, add
        const dialog = {
            title: 'İsmarıcın ləğv edilməsi',
            text: 'İsmarıcı ləğv etmək istədiyinizə əminsiniz?',
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
                    if (team.name.toLowerCase().includes(searchText.value.toLowerCase()) || team.surname.toLowerCase().includes(searchText.value.toLowerCase()) || team.email.toLowerCase().includes(searchText.value.toLowerCase())) {
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

        const removeInner = () => {
            axios.post('/composer/messages/remove', {
                member: currentMember.value.id,
            })
            .then(function (response) {
                if(response.data.success == true) {
                    dialogShow.value = false;
                    currentMember.value = null;
                    view.value = 'table';
                    showAlert('Təbriklər', 'İsmarıc uğurla ləğv edildi');
                    teams.value = response.data.teams;
                    paginate();
                }else {
                    dialogShow.value = false;
                    currentMember.value = null;
                    showAlert('Xəta', 'İsmarıcı ləğv etmək mümkün olmadı');
                }
            })
            .catch(function (error) {
                dialogShow.value = false;
                currentMember.value = null;
                showAlert('Xəta', 'İsmarıcı ləğv etmək mümkün olmadı');
            })
        }

        const remove = () => {
            axios.post('/composer/messages/remove', {
                member: currentMember.value,
            })
            .then(function (response) {
                if(response.data.success == true) {
                    dialogShow.value = false;
                    currentMember.value = null;
                    showAlert('Təbriklər', 'İsmarıc uğurla ləğv edildi');
                    teams.value = response.data.teams;
                    paginate();
                }else {
                    dialogShow.value = false;
                    currentMember.value = null;
                    showAlert('Xəta', 'İsmarıcı ləğv etmək mümkün olmadı');
                }
            })
            .catch(function (error) {
                dialogShow.value = false;
                currentMember.value = null;
                showAlert('Xəta', 'İsmarıcı ləğv etmək mümkün olmadı');
            })
        }

        const openAdd = (member) => {
            currentMember.value = member;
            view.value = 'add';
        }

        const closeAdd = () => {
            currentMember.value = null;
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
            closeAdd,
            removeInner
        }
    },
})
</script>
