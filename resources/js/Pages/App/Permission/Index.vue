<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Permissões
                </h2>

                <Button @click="showModal=true" variant="info" class="items-center gap-2 max-w-xs" v-slot="{ iconSizeClasses }">
                    <PlusCircleIcon aria-hidden="true" :class="iconSizeClasses" />
                    <span>Nova permissão</span>
                </Button>
            </div>
        </template>

        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">

            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
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
                        <tr v-for="permission in permissions" :key="permission.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ permission.name }}
                            </th>
                            <td class="py-4 px-6">
                                {{ permission.created_at }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Editar
                                    </button>
                                    <button type="button" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Apagar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <t-modal @closed="cleanForm" :classes="modalClasses" :fixedClasses="fixedClasses" v-model="showModal">

                <form @submit.prevent="submit">
                    <div class="mb-6 mt-6">
                        <t-input :classes="inputClasses" v-model="dataForm.name" name="name" placeholder="Digite o nome da permissão"/>
                    </div>

                    <div class="mb-6">
                        <Button :disabled="dataForm.processing" variant="success" class="items-center gap-2 max-w-xs">
                            <svg v-if="dataForm.processing" role="status" class="inline w-7 h-7 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span>Adicionar</span>
                        </Button>
                    </div>
                </form>
                
            </t-modal>

        </div>

        <NotificationGroup group="success">
            <div class="fixed inset-0 flex items-start justify-end p-6 px-4 py-6 pointer-events-none z-50">
                <div class="w-full max-w-sm">
                <Notification
                    v-slot="{ notifications }"
                    enter="transform ease-out duration-300 transition"
                    enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                    enter-to="translate-y-0 opacity-100 sm:translate-x-0"
                    leave="transition ease-in duration-500"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                    move="transition duration-500"
                    move-delay="delay-300"
                >
                    <div
                    class="flex w-full max-w-sm mx-auto mt-4 overflow-hidden bg-white rounded-lg shadow-md"
                    v-for="notification in notifications"
                    :key="notification.id"
                    >
                    <div class="flex items-center justify-center w-12 bg-green-500">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                        </svg>
                    </div>

                    <div class="px-4 py-2 -mx-3">
                        <div class="mx-3">
                        <span class="font-semibold text-green-500">{{ notification.title }}</span>
                        <p class="text-sm text-gray-600">{{ notification.text }}</p>
                        </div>
                    </div>
                    </div>
                </Notification>
                </div>
            </div>
        </NotificationGroup>

        <NotificationGroup group="error">
            <div
                class="fixed inset-0 flex items-start justify-end p-6 px-4 py-6 pointer-events-none z-50"
            >
                <div class="w-full max-w-sm">
                <Notification
                    v-slot="{ notifications }"
                    enter="transform ease-out duration-300 transition"
                    enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                    enter-to="translate-y-0 opacity-100 sm:translate-x-0"
                    leave="transition ease-in duration-500"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                    move="transition duration-500"
                    move-delay="delay-300"
                >
                    <div
                    class="flex w-full max-w-sm mx-auto mt-4 overflow-hidden bg-white rounded-lg shadow-md"
                    v-for="notification in notifications"
                    :key="notification.id"
                    >
                    <div class="flex items-center justify-center w-12 bg-red-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"/>
                    </svg>
                    </div>

                    <div class="px-4 py-2 -mx-3">
                    <div class="mx-3">
                        <span class="font-semibold text-red-500">{{ notification.title }}</span>
                        <p class="text-sm text-gray-600">{{ notification.text }}</p>
                    </div>
                    </div>
                    </div>
                </Notification>
                </div>
            </div>
        </NotificationGroup>
        
    </AuthenticatedLayout>
</template>


<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import { PlusCircleIcon } from "@heroicons/vue/outline";

import { defineComponent } from 'vue';
import { TInput, TModal } from '@variantjs/vue'
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
  components: {
    AuthenticatedLayout, Button, PlusCircleIcon, TInput, TModal, Inertia
  },

  props: {
    permissions: Object
  },
  
  data() {

    return {

        fixedClasses: {
        overlay: 'z-40  overflow-auto scrolling-touch left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-opacity-50',
        wrapper: 'relative p-4 mx-auto z-50 max-w-lg px-3 py-12',
        modal: 'overflow-visible relative bg-white rounded-lg shadow dark:bg-gray-700',
        body: 'p-4',
        header: 'border-b p-4 rounded-t',
        footer: ' p-4 rounded-b',
        close: 'flex items-center justify-center rounded-full absolute right-0 top-0 -m-3 h-8 w-8 transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50'
        },

        modalClasses: {
        overlay: 'bg-black',
        wrapper: '',
        modal: 'bg-white shadow',
        body: 'p-3',
        header: 'border-gray-100',
        footer: 'bg-gray-100',
        close: 'bg-gray-100 text-gray-600 hover:bg-gray-200',
        closeIcon: 'fill-current h-4 w-4',
        overlayEnterClass: 'opacity-0',
        overlayEnterActiveClass: 'transition ease-out duration-100',
        overlayEnterToClass: 'opacity-100',
        overlayLeaveClass: 'opacity-100',
        overlayLeaveActiveClass: 'transition ease-in duration-75',
        overlayLeaveToClass: 'opacity-0',
        enterClass: '',
        enterActiveClass: '',
        enterToClass: '',
        leaveClass: '',
        leaveActiveClass: '',
        leaveToClass: ''
        },

        variants: {
        danger: {
          overlay: 'bg-red-100',
          header: 'border-red-50 text-red-700',
          close: 'bg-red-50 text-red-700 hover:bg-red-200 border-red-100 border',
          modal: 'bg-white border border-red-100 shadow-lg',
          footer: 'bg-red-50'
        }
        },

        inputClasses: "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",

        showModal: false,

        dataForm: this.$inertia.form({
            name: null
        })
    }
  },

  methods: {

        submit() {

            this.dataForm.post("/app/permissions", {

                onSuccess: page => { 

                    this.$notify({
                        group: "success",
                        title: "Successo",
                        text: "Permissão cadastrada com sucesso!"
                    }, 2000) // 2s

                    this.dataForm.reset()
                },

                onError: errors => {

                    this.$notify({
                        group: "error",
                        title: "Oops",
                        text: "Não foi possivel adicionar a permissão!"
                    }, 2000) // 2s

                },
                onFinish: visit => {

                    if(!this.dataForm.hasErrors) {
                        this.dataForm.reset();
                    }
                },

            })
            
        },

        cleanForm() {
            this.dataForm.reset();
            this.dataForm.errors = '';
        },
  }

});
</script>
