<template>
    <div class="modal" id="warningModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-24">
                    <div class="d-flex align-items-center">
                        <img
                            :src="baseURL() + '/img/warning.png'"
                            style="width: 120px; height: auto"
                            class="mr-24"
                            alt="warning icon"
                        />
                        <div class="d-flex flex-column">
                            <span class="text-primary-dark text-bold mb-24">
                                {{message}}
                            </span>
                            <div class="d-flex mt-auto justify-content-between">
                                <a
                                    href="#"
                                    data-dismiss="modal"
                                    class="btn btn-danger min-w-120"
                                    >Re Check</a
                                >
                                <a
                                    @click.prevent="$emit('proceed')"
                                    href="#"
                                    data-dismiss="modal"
                                    class="btn btn-primary-dark min-w-120"
                                    >Proceed</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	props:['message'],
}
</script>