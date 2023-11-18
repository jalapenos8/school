import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/createquiz.js',
                'resources/css/style.css',
                'resources/js/addUser.js',
                'resources/js/alert.js',
                'resources/js/joinQuiz.js',
                'resources/js/login.js',
                'resources/js/openQuiz.js',
                'resources/js/quizInterface.js',
                'resources/js/results.js',
                'resources/js/resultsForTeacher.js',
            ],
            refresh: true,
        }),
    ],
});
