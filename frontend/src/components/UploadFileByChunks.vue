<template>
  <div class="hello">
    <h1>{{ msg }}:</h1>
    <input type="file" @change="handleFileChange">
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component'
import config from '@/conf/main'; 

@Options({
  props: {
    msg: String
  }
})
export default class UploadFileByChunks extends Vue {
  msg!: string

  async handleFileChange (event: any) {
    const file = event.target.files[0]
    console.log("File info:", file)
    if (file) {
      const chunkSize = 1024 * 1024 // 1MB chunk size
      let offset = 0

      while (offset < file.size) {
        const chunk = file.slice(offset, offset + chunkSize)
        const formData = new FormData()
        formData.append('fileChunk', chunk)
        formData.append('offset', offset.toString())

        offset += chunkSize
        formData.append('is_last_chunk', offset < file.size ? '0' : '1')
        formData.append('original_file_name', file.name)

        const response = await this.uploadChunk(formData)
        console.log('Received response: ', response);
      }

      //this.$root.$emit('FileLoaded');

      console.log('File upload complete!')
    }
  }

  async uploadChunk (formData: FormData) {
    try {
      const response = await fetch(config.apiUrl + '/upload-chunk', {
        method: 'POST',
        body: formData
      })

      return response

      if (!response.ok) {
        throw new Error('Error uploading chunk')
      }
    } catch (error) {
      console.error('Error uploading chunk:', error)
    }
  }
}
</script>

<style scoped lang="scss">

</style>
