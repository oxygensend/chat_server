<template>
    <div class="w-100">
        <form>
            <div class="mb-3">
                <label for="room" class="form-label">Select room</label>
                <select id="room" class="form-select"></select>
            </div>
            <!--            Dodac show dopiero gdy pokoj wybrany-->
            <div class="mb-3">
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
        }
    }
</script>
