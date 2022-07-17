<template>
  <AuthenticatedLayout title="Dashboard">
    <template #header>
      <div
        class="
          flex flex-col
          gap-4
          md:flex-row md:items-center md:justify-between
        "
      >
        <h2 class="text-xl font-semibold leading-tight">Permissões</h2>

        <div>
          <Button
            v-slot="{ iconSizeClasses }"
            class="items-center gap-2 max-w-xs"
            variant="info"
            @click="showModal = true"
          >
            <PlusCircleIcon :class="iconSizeClasses" aria-hidden="true" />
            <span>Nova permissão</span>
          </Button>

          <Button
            @click="deleteAll()"
            v-if="selected"
            v-slot="{ iconSizeClasses }"
            class="ml-2 items-center gap-2 max-w-xs"
            variant="danger"
          >
            <PlusCircleIcon :class="iconSizeClasses" aria-hidden="true" />
            <span>Apagar todos</span>
          </Button>
        </div>
      </div>
    </template>

    <div
      class="
        p-6
        overflow-hidden
        bg-white
        rounded-md
        shadow-md
        dark:bg-dark-eval-1
      "
    >
      <!--START TABLE -->

      <div class="mb-1 pb-4 bg-white dark:bg-gray-900">
        <label class="sr-only" for="table-search">Search</label>
        <div class="relative mt-1">
          <div
            class="
              flex
              absolute
              inset-y-0
              left-0
              items-center
              pl-3
              pointer-events-none
            "
          >
            <svg
              aria-hidden="true"
              class="w-5 h-5 text-gray-500 dark:text-gray-400"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                clip-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                fill-rule="evenodd"
              ></path>
            </svg>
          </div>
          <input
            id="table-search"
            class="
              block
              p-2
              pl-10
              w-80
              text-sm text-gray-900
              bg-gray-50
              rounded-lg
              border border-gray-300
              focus:ring-blue-500 focus:border-blue-500
              dark:bg-gray-700
              dark:border-gray-600
              dark:placeholder-gray-400
              dark:text-white
              dark:focus:ring-blue-500
              dark:focus:border-blue-500
            "
            placeholder="Buscar por nome"
            type="text"
          />
        </div>
      </div>

      <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table
          class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
          <thead
            class="
              text-xs text-gray-700
              uppercase
              bg-gray-50
              dark:bg-gray-700 dark:text-gray-400
            "
          >
            <tr>
              <th class="p-4" scope="col">
                <div class="flex items-center">
                  <t-checkbox
                    @click="checkedAll((checkAll = !checkAll)), selecteds()"
                    :checked="checkAll"
                    v-model="checkedPermissions"
                    name=""
                    :value="{ id: 'null' }"
                    classes="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  ></t-checkbox>
                </div>
              </th>
              <th class="py-3 px-6" scope="col">Permissão</th>
              <th class="py-3 px-6" scope="col">Data cadastro</th>
              <th class="py-3 px-6" scope="col">Ação</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="permission in permissions"
              :key="permission.id"
              class="
                bg-white
                border-b
                dark:bg-gray-800 dark:border-gray-700
                hover:bg-gray-50
                dark:hover:bg-gray-600
              "
            >
              <td class="p-4 w-4">
                <div class="flex items-center">
                  <t-checkbox
                    @change="selecteds()"
                    v-model="checkedPermissions"
                    name="options[]"
                    :value="{
                      id: permission.id,
                      name: permission.name,
                    }"
                    classes="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  ></t-checkbox>
                </div>
              </td>
              <th
                class="
                  py-4
                  px-6
                  font-medium
                  text-gray-900
                  whitespace-nowrap
                  dark:text-white
                "
                scope="row"
              >
                {{ permission.name }}
              </th>
              <td class="py-4 px-6">
                {{ permission.created_at }}
              </td>

              <td class="py-4 px-6">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                  <button
                    type="button"
                    class="
                      inline-flex
                      items-center
                      py-2
                      px-4
                      text-sm
                      font-medium
                      text-gray-900
                      bg-white
                      rounded-l-lg
                      border border-gray-200
                      hover:bg-gray-100 hover:text-blue-700
                      focus:z-10
                      focus:ring-2
                      focus:ring-blue-700
                      focus:text-blue-700
                      dark:bg-gray-700
                      dark:border-gray-600
                      dark:text-white
                      dark:hover:text-white
                      dark:hover:bg-gray-600
                      dark:focus:ring-blue-500
                      dark:focus:text-white
                    "
                  >
                    <svg
                      class="mr-2 w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                      ></path>
                    </svg>
                    Editar
                  </button>
                  <button
                    @click="deletePermission(permission.id, permission.name)"
                    type="button"
                    class="
                      inline-flex
                      items-center
                      py-2
                      px-4
                      text-sm
                      font-medium
                      text-gray-900
                      bg-white
                      rounded-r-md
                      border border-gray-200
                      hover:bg-gray-100 hover:text-blue-700
                      focus:z-10
                      focus:ring-2
                      focus:ring-blue-700
                      focus:text-blue-700
                      dark:bg-gray-700
                      dark:border-gray-600
                      dark:text-white
                      dark:hover:text-white
                      dark:hover:bg-gray-600
                      dark:focus:ring-blue-500
                      dark:focus:text-white
                    "
                  >
                    <svg
                      class="mr-2 w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      ></path>
                    </svg>
                    Apagar
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!--END TABLE-->

      <t-modal
        v-model="showModal"
        :classes="modalClasses"
        :clickToClose="clickToClose"
        :fixedClasses="fixedClasses"
      >
        <form @submit.prevent="submit">
          <div class="mb-6 mt-6">
            <label
              class="
                block
                mb-2
                text-sm
                font-medium
                text-gray-900
                dark:text-gray-300
              "
              for=""
              >Digite o nome da permissão:</label
            >
            <t-input
              v-model="dataForm.name"
              :classes="inputClasses"
              name="name"
              placeholder="Ex: editar"
            />
          </div>

          <div class="mb-6">
            <Button
              :disabled="dataForm.processing"
              class="items-center gap-2 max-w-xs"
              variant="success"
            >
              <svg
                v-if="dataForm.processing"
                class="
                  inline
                  w-7
                  h-7
                  mr-2
                  text-gray-200
                  animate-spin
                  dark:text-gray-600
                  fill-gray-600
                  dark:fill-gray-300
                "
                fill="none"
                role=""
                viewBox="0 0 100 101"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                  fill="currentColor"
                />
                <path
                  d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                  fill="currentFill"
                />
              </svg>
              <span>Adicionar</span>
            </Button>
          </div>
        </form>
      </t-modal>
    </div>

    <NotificationGroup group="success">
      <div
        class="
          fixed
          inset-0
          flex
          items-start
          justify-end
          p-6
          px-4
          py-6
          pointer-events-none
          z-50
        "
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
              v-for="notification in notifications"
              :key="notification.id"
              class="
                flex
                w-full
                max-w-sm
                mx-auto
                mt-4
                overflow-hidden
                bg-white
                rounded-lg
                shadow-md
              "
            >
              <div class="flex items-center justify-center w-12 bg-green-500">
                <svg
                  class="w-6 h-6 text-white fill-current"
                  viewBox="0 0 40 40"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"
                  />
                </svg>
              </div>

              <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                  <span class="font-semibold text-green-500">{{
                    notification.title
                  }}</span>
                  <p class="text-sm text-gray-600">
                    {{ notification.text }}
                  </p>
                </div>
              </div>
            </div>
          </Notification>
        </div>
      </div>
    </NotificationGroup>

    <NotificationGroup group="error">
      <div
        class="
          fixed
          inset-0
          flex
          items-start
          justify-end
          p-6
          px-4
          py-6
          pointer-events-none
          z-50
        "
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
              v-for="notification in notifications"
              :key="notification.id"
              class="
                flex
                w-full
                max-w-sm
                mx-auto
                mt-4
                overflow-hidden
                bg-white
                rounded-lg
                shadow-md
              "
            >
              <div class="flex items-center justify-center w-12 bg-red-500">
                <svg
                  class="w-6 h-6 text-white fill-current"
                  viewBox="0 0 40 40"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"
                  />
                </svg>
              </div>

              <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                  <span class="font-semibold text-red-500">{{
                    notification.title
                  }}</span>
                  <p class="text-sm text-gray-600">
                    {{ notification.text }}
                  </p>
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
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import Button from "@/Components/Button.vue";
import { PlusCircleIcon } from "@heroicons/vue/outline";

import { defineComponent } from "vue";
import { TInput, TModal, TCheckbox } from "@variantjs/vue";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
  components: {
    AuthenticatedLayout,
    Button,
    PlusCircleIcon,
    TInput,
    TModal,
    Inertia,
    TCheckbox,
  },

  props: {
    permissions: Object,
  },

  data() {
    return {
      fixedClasses: {
        overlay:
          "z-40  overflow-auto scrolling-touch left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-opacity-50",
        wrapper: "relative p-4 mx-auto z-50 max-w-lg px-3 py-12",
        modal:
          "overflow-visible relative bg-white rounded-lg shadow dark:bg-gray-700",
        body: "p-4",
        header: "border-b p-4 rounded-t",
        footer: " p-4 rounded-b",
        close:
          "flex items-center justify-center rounded-full absolute right-0 top-0 -m-3 h-8 w-8 transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50",
      },

      modalClasses: {
        overlay: "bg-black",
        wrapper: "",
        modal: "bg-white shadow",
        body: "p-3",
        header: "border-gray-100",
        footer: "bg-gray-100",
        close: "bg-gray-100 text-gray-600 hover:bg-gray-200",
        closeIcon: "fill-current h-4 w-4",
        overlayEnterClass: "opacity-0",
        overlayEnterActiveClass: "transition ease-out duration-100",
        overlayEnterToClass: "opacity-100",
        overlayLeaveClass: "opacity-100",
        overlayLeaveActiveClass: "transition ease-in duration-75",
        overlayLeaveToClass: "opacity-0",
        enterClass: "",
        enterActiveClass: "",
        enterToClass: "",
        leaveClass: "",
        leaveActiveClass: "",
        leaveToClass: "",
      },

      variants: {
        danger: {
          overlay: "bg-red-100",
          header: "border-red-50 text-red-700",
          close:
            "bg-red-50 text-red-700 hover:bg-red-200 border-red-100 border",
          modal: "bg-white border border-red-100 shadow-lg",
          footer: "bg-red-50",
        },
      },

      inputClasses:
        "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",

      showModal: false,
      clickToClose: false,
      checkAll: false,
      checkedPermissions: [],
      selected: false,

      dataForm: this.$inertia.form({
        name: null,
      }),
    };
  },

  methods: {
    submit() {
      this.dataForm.post("/app/permissions", {
        onSuccess: () => {
          this.$notify(
            {
              group: "success",
              title: "Successo",
              text: "Permissão cadastrada com sucesso!",
            },
            2000
          ); // 2s

          //this.showModal = false;
          this.dataForm.reset();
        },

        onError: () => {
          this.$notify(
            {
              group: "error",
              title: "Oops",
              text: "Não foi possivel adicionar a permissão!",
            },
            2000
          ); // 2s
        },
        onFinish: () => {
          if (!this.dataForm.hasErrors) {
            this.dataForm.reset();
          }
        },
      });
    },

    deletePermission(id, name) {
      Inertia.delete(`/app/permission/${id}`, {
        onBefore: () => confirm(`Desea realmente exluir a permissão ${name} ?`),

        onSuccess: (page) => {
          this.$notify(
            {
              group: "success",
              title: "Successo",
              text: "Deletado com sucesso!",
            },
            2000
          ); // 2s

          this.cleanPermissionsChecked();
          this.cleanForm();
        },

        onError: (errors) => {
          this.$notify(
            {
              group: "error",
              title: "Oops",
              text: "Não foi possivel deletar a permissão!",
            },
            2000
          ); // 2s

          this.cleanPermissionsChecked();
          this.cleanForm();
        },
      });
    },

    deleteAll() {
      this.$inertia.form(this.checkedPermissions).delete("/app/permission", {
        onBefore: () =>
          confirm(`Deseja realmente exluir as permissões selecionadas ?`),

        onSuccess: (page) => {
          this.$notify(
            {
              group: "success",
              title: "Successo",
              text: "Permissões Deletadas com sucesso!",
            },
            2000
          ); // 2s

          this.cleanPermissionsChecked();
          this.cleanForm();
        },

        onError: (errors) => {
          this.$notify(
            {
              group: "error",
              title: "Oops",
              text: "Não foi possivel deletar as permissões!",
            },
            2000
          ); // 2s
        },
      });
    },

    checkedAll(checkAll) {
      if (checkAll) {
        for (let i = 0; i < this.permissions.length; i++) {
          this.checkedPermissions[i] = {
            id: this.permissions[i].id,
            name: this.permissions[i].name,
          };
        }
      } else {
        this.checkedPermissions = [];
      }
    },

    cleanPermissionsChecked() {
      this.checkedPermissions = [];
      this.selected = false;
      this.checkAll = false;
    },

    cleanForm() {
      this.dataForm.reset();
    },

    selecteds() {
      this.checkedPermissions.length > 1
        ? (this.selected = true)
        : (this.selected = false);

      console.log(this.checkedPermissions.length);
    },
  },

  mounted() {
    console.log(this.checkedPermissions.length);
  },
});
</script>
