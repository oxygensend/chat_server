<template>
    <div>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label"
                       for="exampleCheck1"
                       @click="check_password">Enter password</label>
            </div>

            <div class="mb-3" v-show="password_selected">
                <label for="inputPassword5" class="form-label">Password</label>
                <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
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
        };
    },
    methods: {
        check_password() {
            this.password_selected = !this.password_selected;
        }
    }
};
</script>
