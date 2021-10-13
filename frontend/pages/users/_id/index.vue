<template>
    <div class="container mx-auto mt-16">
        <div class="flex space-x-6 mx-auto">
            <div class="flex flex-col items-end w-1/3">
                <h2 class="text-3xl">{{ user.name }}</h2>

                <template v-if="friendRequestSentFrom">
                    <div class="flex">
                        <form @submit.prevent="acceptFriend">
                            <GreenButton type="submit">Accept</GreenButton>
                        </form>
                        <form @submit.prevent="denyFriend" class="ml-3">
                            <RedButton type="submit">Ignore</RedButton>
                        </form>
                    </div>
                </template>

                <template v-else-if="friendRequestSentTo">
                    <span>Pending</span>
                </template>

                <template v-else-if="isFriendsWith">
                    <form @submit.prevent="deleteFriend">
                        <RedButton type="submit">Unfriend</RedButton>
                    </form>
                </template>

                <template v-else-if="this.$auth.user.id !== this.user.id">
                    <form @submit.prevent="addFriend">
                        <BlueButton type="submit">Add Friend</BlueButton>
                    </form>
                </template>
            </div>
            <div class="flex border-l mt-3 w-2/3">
                <div class="flex mb-3 ml-3">
                    <img
                        src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MXx8c2lsaG91ZXR0ZXxlbnwwfHwwfA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                        class="w-8 h-8 rounded-full object-cover"
                    />
                    <div class="flex flex-col">
                        <span class="text-xl ml-2">{{ user.name }}</span>
                        <span class="text-xl ml-2">{{ user.email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { TYPE } from 'vue-toastification'

export default {
    middleware: 'auth',

    data() {
        return {
            user: {},
            isFriendsWith: '',
            friendRequestSentTo: '',
            friendRequestSentFrom: '',
        }
    },

    created() {
        this.getUser()
    },

    methods: {
        async getUser() {
            try {
                await this.$axios
                    .$get(`/api/users/${this.$route.params.id}`)
                    .then((res) => {
                        this.user = res.user
                        this.isFriendsWith = res.isFriendsWith
                        this.friendRequestSentTo = res.friendRequestSentTo
                        this.friendRequestSentFrom = res.friendRequestSentFrom
                    })
            } catch (err) {
                this.$toast(err.response.data.message, {
                    type: TYPE.ERROR,
                })
            }
        },

        async addFriend() {
            try {
                await this.$axios
                    .$post(`/api/friends/${this.$route.params.id}`)
                    .then(() => this.getUser())
            } catch (err) {
                this.$toast(err.response.data.message, {
                    type: TYPE.ERROR,
                })
            }
        },

        async acceptFriend() {
            try {
                await this.$axios
                    .$patch(`/api/friends/${this.$route.params.id}`)
                    .then(() => this.getUser())
            } catch (err) {
                this.$toast(err.response.data.message, {
                    type: TYPE.ERROR,
                })
            }
        },

        async denyFriend() {
            try {
                await this.$axios
                    .$get(`/api/friends/${this.$route.params.id}`)
                    .then(() => this.getUser())
            } catch (err) {
                this.$toast(err.response.data.message, {
                    type: TYPE.ERROR,
                })
            }
        },

        async deleteFriend() {
            try {
                await this.$axios
                    .$delete(`/api/friends/${this.$route.params.id}`)
                    .then(() => this.getUser())
            } catch (err) {
                this.$toast(err.response.data.message, {
                    type: TYPE.ERROR,
                })
            }
        },
    },
}
</script>
