<template>
  <div class="files-container">
    <table>
      <thead>
        <tr>
          <th>File Name</th>
          <th>Valid Rows Count</th>
          <th>Invalid Rows Count</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="file in files" :key="file.id">
          <td>{{ file.original_filename }}</td>
          <td>{{ file.valid_rows_count }}</td>
          <td>{{ file.invalid_rows_count }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  import axios from 'axios';
  import config from '@/conf/main';
  export default {
    data() {
      return {
        files: []
      };
    },
    mounted() {
      this.fetchFiles();
      // this.$root.$on('FileLoaded', (text) => { // here you need to use the arrow function
      //   this.fetchFiles();
      // })
      setInterval(function(){
          this.fetchFiles();
      }.bind(this), 2000);
    },
    methods: {
      fetchFiles() {
        axios.get(config.apiUrl + '/files')
          .then(response => {
            this.files = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      }
    }
  };
</script>

<style scoped lang="scss">
.files-container{
    width: 400px;
    margin: 40px auto;

    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
}

</style>
