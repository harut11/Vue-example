<template>
    <footer>
        <div class="container h-100">
            <div class="d-flex align-items-center h-100">
                <div id="copyright-text">
                    {{ copyright }}
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        data() {
            return {
                copyright: 'Copyright 2019'
            }
        }
    }
</script>