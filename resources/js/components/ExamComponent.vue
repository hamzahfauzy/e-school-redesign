<template>
    <div>
        <div class="row">
            <div class="col-md-9">
                <h2>{{exam.name}}</h2>
                <div class="card">
                    <div class="card-header">{{questionActive.title}}</div>

                    <div class="card-body">
                        <p>{{questionActive.description}}</p>
                        <label v-if="questionActive.type == 'Pilihan Berganda'" v-for="answer in questionActive.answers" class="container-radio">{{answer.title}}
                            <input type="radio" :value="answer.id" v-model="answered[questionActive.id]">
                            <span class="checkmark"></span>
                        </label>

                        <div v-if="questionActive.type == 'Essay'">
                            <label>Jawab :</label>
                            <textarea class="form-control" rows="10" v-model="answered[questionActive.id]" style="resize: none;"></textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button v-if="index > 0" class="btn z-techno-btn btn-primary" @click="questionNavigation(index-1,1)">Soal Sebelumnya</button>
                        <button v-if="exam.questions != undefined && index == exam.questions.length-1" class="btn z-techno-btn btn-success" @click="finishExam()">Selesai</button>
                        <button v-if="exam.questions != undefined && index < exam.questions.length-1" class="btn z-techno-btn btn-primary" @click="questionNavigation(index+1,1)">Soal Selanjutnya</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <h2>&nbsp;</h2>
                <div class="card">
                    <div class="card-header">Navigasi Soal</div>

                    <div class="card-body">
                        <button v-for="(question,idx) in exam.questions" class="btn z-techno-btn btn-primary btn-block" :class="{'question-active':index == idx,'question-answered':questionAnswered(question.id)}" @click="questionNavigation(idx)">{{++idx}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'exam',
    props: [
        'id',
        'student_id'
    ],
    data(){
        return {
            exam: {},
            questionActive: {},
            answered:{},
            index:0,
            headers:{},
        }
    },
    mounted() {
        // console.log('Component mounted.')
    },
    async created(){
        this.headers = {
            'Content-Type':'application/json'
        }
        await this.loadExam()
        await this.loadAnswered()
    },
    methods: {
        async loadExam(){
            let response = await fetch(window.config.getApiUrl()+'/exam/get/'+this.id)
            let data = await response.json()
            this.exam = data
            this.questionActive = this.exam.questions[this.index]
            this.exam.questions.forEach((question) => {
                if(question.type == 'Essay')
                    this.answered[question.id] = null
                else
                    this.answered[question.id] = null
            })
            return data
        },
        async loadAnswered(){
            let response = await fetch(window.config.getApiUrl()+'/exam/get/'+this.id+'/answers/'+this.student_id)
            let data = await response.json()
            if(data.length != 0)
                this.answered = data
            return data
        },
        questionNavigation(index,status=false){
            if(!status)
                index = index - 1
            this.index = index
            this.questionActive = this.exam.questions[index]
            this.sendAnswer()
        },
        async finishExam(){
            await this.sendAnswer()
            var n = window.confirm('Apakah anda yakin menyelesaikan kuis ini ?')
            if(!n)
                return
            let response = await fetch(window.config.getApiUrl()+'/exam/finish',{
                method:'POST',
                headers:this.headers,
                body:JSON.stringify({
                    student_id:this.student_id,
                    exam_id:this.id
                })
            })
            let data = await response.json()
            if(data.success == true)
                location=window.config.baseUrl()+'/student/exams'
        },
        async sendAnswer(){
            let response = await fetch(window.config.getApiUrl()+'/exam_item/answer',{
                method:'POST',
                headers:this.headers,
                body:JSON.stringify({
                    answers:this.answered,
                    student_id:this.student_id,
                    exam_id:this.id
                })
            })
            let data = await response.json()
        },
        questionAnswered(id){
            return this.answered[id] != undefined
        }
    }
}
</script>

<style>
/* The container */
.container-radio {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container-radio input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container-radio:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container-radio input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container-radio input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container-radio .checkmark:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
}

.question-active {
    background-color: red !important;
}

.question-answered {
    background-color: #38c172;
}
textarea.form-control {
    border-radius:0px;
}
</style>
