<template>
    <div class="w-100">
        <form>
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
                        {{ room.name }}
                    </option>
                </select>
            </div>

            <div v-show="password" class="mb-3">
                <label for="inputPassword5" class="form-label">Password</label>
                <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
            </div>

            <div class="position-relative">
                <button type="submit" class="btn btn-primary">Submit</button>
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
                password: false
            }
        },
        mounted() {
          axios.get('/api/rooms').then(response => {
              this.rooms = response.data.data
          })
        },
        methods: {
            cascade(e) {
              const r = this.rooms.find(room => room.id == e.target.value);
              this.password = !!r.password_require;
            }
        }
    }
</script>
