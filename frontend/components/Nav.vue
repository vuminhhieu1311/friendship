<template>
    <div class="bg-pink-400 text-white text-md px-9">
        <nav class="container flex justify-between items-center mx-auto py-5">
            <span class="font-semibold text-2xl">Friendzone</span>
            <div class="space-x-2">
                <template v-if="this.$auth.loggedIn">
                    <span
                        >Welcome,
                        <NuxtLink to="#" class="capitalize hover:text-teal-200">
                            {{ this.$auth.user.name }}
                        </NuxtLink>
                    </span>
                    <NuxtLink to="/friends" class="hover:text-teal-200">
                        FRIENDS
                    </NuxtLink>
                    <NuxtLink to="/users" class="hover:text-teal-200">
                        USERS
                    </NuxtLink>
                    <NuxtLink to="/dashboard" class="hover:text-teal-200">
                        DASHBOARD
                    </NuxtLink>
                    <a
                        @click.prevent="logout"
                        class="hover:text-teal-200 cursor-pointer"
                        >LOGOUT</a
                    >
                </template>
                <template v-else>
                    <NuxtLink to="/auth/register" class="hover:text-teal-200">
                        REGISTER
                    </NuxtLink>
                    <NuxtLink to="/auth/login" class="hover:text-teal-200">
                        LOGIN
                    </NuxtLink>
                </template>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$auth.logout()
        },
    },
}
</script>
