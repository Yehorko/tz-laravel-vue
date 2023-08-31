<template>
  <div class="home">
    <UploadFileByChunks msg="Choose your CSV File"/>
  </div>
  <div class="home">
    <FileTable/>
  </div>
</template>

<script lang="ts">
	import { Options, Vue } from 'vue-class-component'
	import UploadFileByChunks from '@/components/UploadFileByChunks.vue'
	import FileTable from '@/components/FileTable.vue'

	@Options({
	  components: {
	    UploadFileByChunks,
	    FileTable
	  }
	})
	export default class HomeView extends Vue {}
</script>
