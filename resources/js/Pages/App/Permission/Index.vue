<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Permissões
                </h2>

                <div>
                    <Button @click="openModal()" variant="primary" class="mr-2 items-center gap-2 max-w-xs" v-slot="{ iconSizeClasses }">
                        <PlusCircleIcon aria-hidden="true" :class="iconSizeClasses" />
                        <span>Nova permisssão</span>
                    </Button>
                    <Button @click="deleteAllPermissions()" v-if="checkAll"  variant="danger" class="items-center gap-2 max-w-xs" v-slot="{ iconSizeClasses }">
                        <TrashIcon aria-hidden="true" :class="iconSizeClasses" />
                        <span>Apagar todos</span>
                    </Button>
                </div>

            </div>
        </template>

        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
           
            <!-- START List permissions-->
            <div class="overflow-x-auto relative  sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <t-checkbox @click="checkboxAll((checkAll = !checkAll))" :checked="checkAll" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </t-checkbox>
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Permissão
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Data cadastro
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Ação
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="permission in permissions" :key="permission.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="p-4 w-4">
                                <div class="flex items-center">
                                    <t-checkbox 
                                        v-model="permissionsChecked"
                                        :value="permission"
                                        @change="checkPermission()"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </t-checkbox>
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ permission.name }}
                            </th>
                            <td class="py-4 px-6">
                                {{ permission.created_at }}
                            </td>
                            <td class="py-4 px-6">
                               <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button @click="edit(permission)" type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Editar
                                    </button>
                                    <button @click="deletePermission(permission)" :disabled="permissionForm.processing" type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Apagar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav class="flex justify-between items-center pt-4" aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">1-10</span> of <span class="font-semibold text-gray-900 dark:text-white">1000</span></span>
                    <ul class="inline-flex items-center -space-x-px">
                        <li>
                            <a href="#" class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 border border-blue-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#" class="block py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- END List permissions-->

            <!-- START Modal register permission -->
            <div v-if="this.isOpen" id="defaultModal" tabindex="-1" aria-hidden="true" class="overflow-y-hidden overflow-x-hidden  fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full flex justify-center items-center">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                            <h3 v-if="!editMode" class="text-lg font-semibold text-gray-800 dark:text-white">
                                Nova permissão
                            </h3>
                            <h3 v-if="editMode" class="text-lg font-semibold text-gray-800 dark:text-white">
                                Editar Permissão
                            </h3>
                            <button @click="closeModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                           <form @submit.prevent="store">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Permissão</label>
                                <input v-model="permissionForm.name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ex: create" required>
                            </div>
                           </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                        
                            <Button v-if="!editMode" @click="store()" :disabled="permissionForm.processing || permissionForm.name === null" variant="success" class="items-center gap-2 max-w-xs"
                                v-slot="{ iconSizeClasses }">
                                <CheckCircleIcon v-if="!permissionForm.processing" aria-hidden="true" :class="iconSizeClasses" />
                                <div v-if="permissionForm.processing" role="status">
                                    <svg class="inline mr-2 w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <span>Salvar</span>
                            </Button>

                            <Button @click="update(permissionForm.id)" v-show="editMode" :disabled="permissionForm.processing || permissionForm.name === ''" variant="info" class="items-center gap-2 max-w-xs"
                                v-slot="{ iconSizeClasses }">
                                <PencilAltIcon v-if="!permissionForm.processing" aria-hidden="true" :class="iconSizeClasses" />
                                <div v-if="permissionForm.processing" role="status">
                                    <svg class="inline mr-2 w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <span>Atualizar</span>
                            </Button>

                            <button @click="closeModal()" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                Fechar
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            <div v-if="this.isOpen" class=" overflow-hidden fixed z-40 inset-0 opacity-50 bg-black"></div>
            <!-- END Modal register permission -->

        </div>

        <Notify/>

    </AuthenticatedLayout>
</template>

<script>
  import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
  import Button from '@/Components/Button.vue';
  import { PlusCircleIcon, CheckCircleIcon, PencilAltIcon, TrashIcon } from "@heroicons/vue/outline";
  import { Inertia } from "@inertiajs/inertia";
  import  Notify  from "@/Pages/Shared/Notify.vue";
  import { TCheckbox } from "@variantjs/vue";

  export default {

    components: {
        AuthenticatedLayout,
        Button,
        PlusCircleIcon,
        CheckCircleIcon,
        PencilAltIcon,
        TrashIcon,
        Inertia,
        Notify,
        TCheckbox
    },

    props: {
        permissions: Object
    },

    data() {
        return {
            isOpen: false,
            editMode: false,
            checkAll: false,
            permissionForm: this.$inertia.form({id: null, name: null}),
            permissionsChecked: []
        }
    },

    methods: {
        openModal() {
            this.isOpen = true;
            this.editMode = false;
        },
        closeModal() {
            this.isOpen = false;
            this.editMode = false;
            this.resetForm();
            this.resetFormEdit();
        },
        resetForm() {
            this.permissionForm.reset();
        },
        resetFormEdit() {
            this.permissionForm.id = null;
            this.permissionForm.name = null;
        },
        store() {
            this.permissionForm.post("permissions", {
                onSuccess: () => {
                    this.resetForm();
                    this.notifyMessage("success", "Successo", "Permissão cadastrada com sucesso!" );
                },
                onError: () => {
                    this.notifyMessage("error", "Oops", "Não foi possivel efetuar o cadastro!" );
                }
            })
        },
        edit(permission) {
            this.openModal();
            this.editMode = true;
            this.permissionForm.id = permission.id;
            this.permissionForm.name = permission.name;
        },
        update(id) {
            this.permissionForm.put(`permission/${id}/edit`, {
                onSuccess: () => {
                    this.resetForm();
                    this.notifyMessage("generic", "Successo", "Permissão atualizada com sucesso!" );
                },
                onError: () => {
                    this.resetForm();
                    this.notifyMessage("error", "Oops", "Não foi possivel atualizar a permissão!" );
                }
            })
        },
        deletePermission(permission) {

            this.permissionForm.delete("permission/" + permission.id, {
                onBefore: () => confirm(`Desea realmente exluir a permissão ${permission.name} ?`),
                onSuccess: () => {
                    this.resetForm();
                    this.notifyMessage("success", "Successo", "Permissão deletada com sucesso!" );
                },
                onError: () => {
                    this.resetForm();
                    this.notifyMessage("error", "Oops", "Não foi possivel deletar a permissão!" );
                }
            })
            
        },
        deleteAllPermissions() {
            this.$inertia.form(this.permissionsChecked).delete("/app/permissions", {
                onBefore: () => confirm("Desea realmente exluir todas as permissões?"),
                onSuccess: () => {
                    this.cleanPermissionsChecked();
                    this.resetForm();
                    this.notifyMessage("success", "Successo", "Permissões deletadas com sucesso!" );
                },
                onError: () => {
                    this.cleanPermissionsChecked();
                    this.resetForm();
                    this.notifyMessage("error", "Oops", "Não foi possivel deletar sa permissões!" );
                },
                onFinish: () => {
                    this.cleanPermissionsChecked();
                }
            })
        },
        cleanPermissionsChecked() {
            this.permissionsChecked = [];
            this.checkAll = false;
        },
        checkPermission() {
            (this.permissionsChecked.length === 0) ? this.checkAll = false : null;
            (this.permissionsChecked.length > 1 ) ? this.checkAll = true : this.checkAll = false
        },
        checkboxAll(checkAll) {
            (checkAll) ? this.permissions.filter((el, index) => { this.permissionsChecked[index] = el}) : this.permissionsChecked = [];
        },
        notifyMessage(group, title, text, time = 2000) {
            this.$notify({group: group, title: title, text: text}, time) // 2s
        }
    }
    
  }
</script>
