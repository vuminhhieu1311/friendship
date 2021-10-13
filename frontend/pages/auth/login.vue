<template>
    <div class="container mx-auto mt-16 sm:px-6 lg:px-8">
        <form
            @submit.prevent="login"
            class="bg-pink-400 rounded mx-auto px-6 py-6 w-1/2"
        >
            <div class="flex flex-col mt-3" v-if="errors">
                <span class="text-red-200 italic">{{ errors }}</span>
            </div>
            <div class="flex flex-col mt-3">
                <label for="email" class="text-white text-base">Email</label>
                <input
                    type="email"
                    v-model="form.email"
                    class="px-2 py-1 rounded"
                    placeholder="Email"
                />
            </div>
            <div class="flex flex-col mt-3">
                <label for="password" class="text-white text-base"
                    >Password</label
                >
                <input
                    type="password"
                    v-model="form.password"
                    class="px-2 py-1 rounded"
                    placeholder="Password"
                />
            </div>
            <div class="text-center mt-3">
                <PinkButton type="submit">Login</PinkButton>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    middleware: 'guest',
    head: {
        title: 'Login',
        meta: [
            { hid: 'description', name: 'description', content: 'Login page' },
        ],
    },

    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            errors: '',
        }
    },

    methods: {
        async login() {
            try {
                await this.$auth.loginWith('laravelSanctum', {
                    data: this.form,
                })
            } catch (err) {
                if ((err.response.status = 422)) {
                    this.errors = err.response.data.errors.email[0]
                }
            }
        },
    },
}
</script>
