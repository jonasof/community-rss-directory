<template lang="pug">
  .enclosure
    audio(controls, preload="none" v-if="isAudio")
      source(:src="enclosure.url" :type="enclosure.type")

    video(controls, preload="none" v-if="isVideo")
      source(:src="enclosure.url" :type="enclosure.type")
</template>

<script>
  export default {
    props: ['enclosure'],
    computed: {
      isAudio () {
        return this.enclosure.type.indexOf('audio') > -1;
      },
      isVideo () {
        return this.enclosure.type.indexOf('video') > -1;
      }
    }
  }
</script>


<style lang="scss" scoped>
  audio {
    width: 100%;
  }
</style>