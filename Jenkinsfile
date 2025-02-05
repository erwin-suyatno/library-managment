pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/erwin-suyatno/library-managment'
            }
        }
        stage('Build & Deploy Backend') {
            steps {
                dir('backend') {  // Pindah ke folder backend
                    sh 'docker-compose build'
                    sh 'docker-compose up -d'
                }
            }
        }
    }
}
