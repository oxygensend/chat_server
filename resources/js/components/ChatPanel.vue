<template>
    <div class=" h-100">
        <div class="border-bottom">
            <h3 class="text-center">{{ name }}</h3>
        </div>
        <div class="chat overflow-auto position-relative h-75">
            <div class="mine messages">
                <div class="message ">
                    Dude
                </div>
            </div>
            <div class="yours messages">
                <div class="message">
                    Hey!
                </div>
                <small class="px-2 text-muted">Antonio Banderas</small>
                <div class="message">
                    You there?
                </div>
                <small class="px-2 text-muted">Oxygensend</small>
                <div class="message">
                    Hello, how's it going?
                </div>
                <small class="px-2 text-muted">2 days ago</small>
            </div>
            <div class="mine messages">
                <div class="message">
                    Great thanks!
                </div>
                <div class="message ">
                    How about you?
                </div>
                <div class="message ">
                    How about you?
                </div><div class="message ">
                How about you?
            </div>
                <div class="message ">
                    How about you?
                </div>
                <div class="message ">
                    How about you?
                </div>
                   <small class="text-muted">2 seconds ago</small>
                <div class="message ">
                    How about you?
                </div>
                    <small class="text-muted">2 seconds ago</small>
            </div>

        </div>
        <div class="df mt-1 input-group">
            <textarea class="form-control shadow-none bg-white" style="resize:none" rows="4"
                      aria-label="With textarea"></textarea>
            <button class="btn btn-primary" type="button">Send</button>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        name: String
    }
}
</script>
