<template>
    <Head :title="Welcome" />
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <template v-if="$page.props.user">
                <Link :href="route('dashboard')" class="text-sm text-gray-700 underline">
                    Valuation tool
                </Link>
                <!-- Authentication -->
                <form @submit.prevent="logout">
                    <jet-dropdown-link as="button">
                        Log Out
                    </jet-dropdown-link>
                </form>
            </template>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>
        <h1>Only 1$/month for the simplified valuation tool !</h1>
    </div>
</template>

<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
            color: #9ca3af;
        }

        a {
            color: #9ca3af;
        }
    }
</style>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'

    export default defineComponent({
        components: {
            Head,
            Link,
            JetDropdownLink
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        },

        methods : {
            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    })
</script>
