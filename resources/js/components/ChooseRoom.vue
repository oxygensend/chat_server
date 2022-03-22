<template>
    <div class="w-100">
        <form method="POST" @submit.prevent="submit">
            <div class="mb-3">
                <label for="room_id" class="form-label">Select room</label>
                <select id="room_id"
                        name="room_id"
                        class="form-select"
                        v-model="fields.room_id"
                        @change="cascade"
                >
                    <option v-for="room in rooms"
                            :value="room.id">
                        {{ `${room.name} : ${room.id}`}}
                    </option>
                </select>

            </div>

            <div v-show="password" class="mb-3">
                <label for="inputPassword5" class="form-label">Password</label>
                <input type="password"
                       id="inputPassword5"
                       class="form-control"
                       name="password"
                       v-model="fields.password"
                       aria-describedby="passwordHelpBlock">

                <div class="alert text-danger " v-if="errors && errors.password">
                    {{ errors.password[0] }}
                </div>
            </div>

            <div class="position-relative">
                <button type="submit" class="btn btn-primary">Connect</button>
                <a :href=url class="link-primary position-absolute bottom-0 end-0">Create new one</a>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        url: String
    },
    data() {
        return {
            rooms: null,
            fields: {},
            password: false,
            errors: {}
        };
    },
    mounted() {
       this.rooms = this.getRooms();
    },
    methods: {
        cascade(e) {
            const r = this.rooms.find(room => room.id == e.target.value);
            this.password = !!r.password_require;
        },
        submit() {
            axios.patch('/api/rooms/' + this.fields.room_id, this.fields).then(response => {
                this.fields = {};
                this.password = false;
                this.errors = {};
                window.location = response.data.redirect
            }).catch(err => {
                    if (err.response.status === 422) {
                        this.errors = err.response.data.errors;
                    }

                    console.log('Error');
                });
        },

        async getRooms() {
            const res = await axios.get('/api/rooms');
            return res.data.data
        }
    }
};
</script>
