<template>
    <div>
        <form method="POST" @submit.prevent="submit">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text"
                       id="name"
                       class="form-control"
                       v-model="fields.name"
                       required autofocus>
               <div class="alert text-danger " v-if="errors && errors.name">
                    {{ errors.name[0] }}
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox"
                       class="form-check-input"
                       id="exampleCheck1"
                       @click="check_password">

                <label class="form-check-label"
                       for="exampleCheck1"
                >Enter password</label>

            </div>

            <div class="mb-3" v-show="password_selected">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-control"
                       v-model="fields.password"
                       aria-describedby="passwordHelpBlock">
                <div class="alert text-danger " v-if="errors && errors.password">
                    {{ errors.password[0] }}
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>

        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            password_selected: false,
            fields: {},
            success: false,
            errors: {}
        };
    },
    methods: {
        check_password() {
            this.password_selected = !this.password_selected;
        },

        submit() {
            axios.post('/api/rooms', this.fields).then(response => {
                this.fields = {};
                this.success = true;
                this.erros = {};
                window.location = '/' + response.data.id;
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }

                console.log('Error');
            });
        }
    }
};
</script>
