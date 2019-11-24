<template>
    <div>
        <h2>Selesaikan Langkah Terakhir</h2>
        <!-- <form method="post" @submit=""> -->
            <div class="form-group">
                <label>ID Sekolah / NPSN / Nama Sekolah</label>
                <input type="text" class="form-control z-techno-el" v-on:keyup="findSchool()" v-model="keyword">
                <div class="school-suggestion">
                    <div class="school-item" v-for="school in schoolSuggestions" @click="setSelectedSchool(school)">
                        <h5 style="color: blue;">{{school.school_id}} - {{school.name}}</h5>
                        <small>{{school.address}}</small>
                    </div>
                </div>
            </div>

            <div class="form-group" v-if="selectedSchool.id != undefined">
                <label>Peran</label>
                <select class="form-control z-techno-el" @change="loadMajor()" v-model="selectedRole">
                    <option value="">- Pilih Peran -</option>
                    <option value="siswa">Siswa</option>
                    <option value="guru">Guru</option>
                </select>
            </div>

            <div class="form-group" v-if="selectedRole != '' && selectedRole == 'siswa'">
                <label>Jurusan</label>
                <select class="form-control z-techno-el" @change="loadClass()" v-model="selectedMajor">
                    <option value="">- Pilih Jurusan -</option>
                    <option v-for="major in majors" :value="major">{{major.name}}</option>
                </select>
            </div>

            <div class="form-group" v-if="selectedMajor.id != undefined">
                <label>Kelas</label>
                <select class="form-control z-techno-el" v-model="selectedClass">
                    <option value="">- Pilih Kelas -</option>
                    <option v-for="classroom in classrooms" :value="classroom">{{classroom.name}}</option>
                </select>
            </div>

            <button v-if="selectedClass.id != undefined || selectedRole == 'guru'" class="btn z-techno-btn z-techno-primary" @click="finishRegistration();"><i class="fa fa-save"></i> Selesaikan Pendaftaran</button>
        <!-- </form> -->
    </div>
</template>

<script>
    export default {
        name: 'final-step',
        props: [
            'id',
        ],
        data(){
            return {
                keyword             : '',
                schoolSuggestions   : {},
                majors              : {},
                classrooms          : {},
                selectedSchool      : {},
                selectedRole        : '',
                selectedMajor       : {},
                selectedClass       : {},
            }
        },
        mounted() {
            // console.log('Component mounted.')
        },
        async created(){
            this.headers = {
                'Content-Type':'application/json'
            }
        },
        methods: {
            async findSchool(){
                if(this.keyword == '')
                    this.schoolSuggestions = {}
                else
                {
                    let response = await fetch(window.config.getApiUrl()+'/school/'+this.keyword)
                    let data = await response.json()

                    this.schoolSuggestions = data
                    return data
                }

                return
            },
            async loadMajor(){
                if(this.selectedRole == 'siswa')
                {
                    let response = await fetch(window.config.getApiUrl()+'/school/get/'+this.selectedSchool.id+'/majors')
                    let data = await response.json()

                    this.majors = data
                    return data
                }
                else
                {
                    this.majors = {}
                    this.selectedMajor = {}
                    this.classrooms = {}
                    this.selectedClass = {}
                }

                return
            },
            async loadClass(){
                if(this.selectedRole == 'siswa')
                {
                    let response = await fetch(window.config.getApiUrl()+'/school/get/'+this.selectedSchool.id+'/majors/'+this.selectedMajor.id+'/classrooms')
                    let data = await response.json()

                    this.classrooms = data
                    return data
                }

                return
            },
            setSelectedSchool(school){
                this.selectedSchool = school
                this.keyword = school.school_id+' - '+school.name
                this.schoolSuggestions = {}
            },
            async finishRegistration(){
                var n = confirm('apakah anda yakin telah memasukkan data dengan benar ?')
                if(!n)
                    return
                let response = await fetch(window.config.getApiUrl()+'/finish-registration',{
                    method: 'POST',
                    headers: this.headers,
                    body: JSON.stringify({
                        user_id :this.id,
                        school  :this.selectedSchool.id,
                        role    :this.selectedRole,
                        major   :this.selectedMajor.id,
                        classroom  :this.selectedClass.id,
                    })
                })
                let data = await response.json()
                if(data.success)
                    location='/home'
                return
            },
        }
    }
</script>
