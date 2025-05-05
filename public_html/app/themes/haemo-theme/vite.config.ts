//import * as fs from 'node:fs/promises'
import * as fs from 'node:fs/promises'
import { defineConfig, type UserConfig } from 'vite';
import * as path from 'path';
import copy from 'rollup-plugin-copy';

const config: UserConfig = {
    //publicDir: 'dist',
    base: 'https://localhost:8081/',
    resolve: {
        alias: {
            "@": path.resolve(__dirname, './src'),
            "@vars": path.resolve(__dirname, './src/scss/vars'),
            "@img": path.resolve(__dirname, './src/img')
        },
    },
    build: {
        assetsDir: '',
        assetsInlineLimit: 0,
        emptyOutDir: true,
        manifest: true,
        outDir: 'resources/dist',
        rollupOptions: {
            input: ['src/ts/app.ts'],
            output: {
                entryFileNames: `js/[name].js`,
                chunkFileNames: `js/[name].js`,
                assetFileNames: ({name}) => {
                    if (/\.(gif|jpe?g|png|webp)$/.test(name ?? '')){
                        return 'img/[name][extname]';
                    }

                    if (/\.(woff2?)$/.test(name ?? '')){
                        return 'fonts/[name][extname]';
                    }

                    if (/\.(svg)$/.test(name ?? '')){
                        return 'svg/[name][extname]';
                    }

                    if (/\.css$/.test(name ?? '')) {
                        return 'css/[name][extname]';
                    }

                    // default value
                    // ref: https://rollupjs.org/guide/en/#outputassetfilenames
                    return '[name][extname]';
                }
            }
        },
    },
    server: {
        open: false,
        port: 8081,
        strictPort: true,
        host: true,
        origin: "https://localhost:8081",
        cors: {
            origin: "*"
        },
        https: {
            key: await fs.readFile('/home/yarops/srvdirs/certs/data/localhost/dev.key'),
            cert: await fs.readFile('/home/yarops/srvdirs/certs/data/localhost/dev.crt')
        }
    },
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler' // or "modern"
            }
        }
    },
    plugins: [
        copy({
            targets: [
                { src: 'src/svg/**/*', dest: 'resources/dist/svg' },
                { src: 'src/img/**/*', dest: 'resources/dist/img' },
                { src: 'src/favicons/**/*', dest: 'resources/dist/favicons' }
            ],
            verbose: true,
            hook: 'writeBundle'
        }),
        {
            name: 'php',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.php')) {
                    server.ws.send({ type: 'full-reload', path: '*' })
                }
            },
        }
    ],
}

// declare environment variables Vite
let started = false
export default defineConfig(async ({ command }) => {
    console.log('started' + started);
    if (!started) {
        const isDev = (process.env.NODE_ENV === 'development')
        const env = {
            mode:  isDev ? "development" : "production",
            key: isDev ? "dev" : Number(new Date()),
            command: command
        };

        try {
            console.log('replacefile');
            await fs.writeFile('env.json', JSON.stringify(env));
        } catch (err) {
            let message = 'Unknown Error'
            if (err instanceof Error) {
                message = err.message
            }
            console.error('Error occurred while reading directory:', message)
        }


        started = true
    }
    return config
})

