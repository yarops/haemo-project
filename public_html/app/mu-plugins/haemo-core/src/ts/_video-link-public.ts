import Cookies from 'js-cookie';
import {
    alert
} from '@pnotify/core';
import '@pnotify/core/dist/PNotify.css';
import '@pnotify/core/dist/BrightTheme.css';

class VideoLink {
    btn!: HTMLElement;
    link!: string;
    linkPublicEl!: HTMLInputElement;
    core = (window as any).core;


    constructor() {
        const getBtn = document.querySelector('.js-get-public-video');
        const linkEl = document.getElementById('acf-haemo_video_link') as HTMLInputElement;
        const linkPublicEl = document.getElementById('acf-haemo_video_public_link');

        if (getBtn === null || linkEl === null || linkPublicEl === null) {
            return;
        }

        this.btn = getBtn as HTMLElement;
        this.linkPublicEl = linkPublicEl as HTMLInputElement;
        this.link = linkEl.value ?? '';

        this.clickListener();
    }

    clickListener() {
        const getLink = (ev: Event) => {
            ev.preventDefault();

            const el = ev.target as HTMLElement;

            if (el === null) {
                return false;
            }

            const dataRequest = {
                postId: this.core.postID,
                link: this.link
            }

            const dataSend = {
                action: 'get_video_link',
                nonce: this.core.nonce,
                data: JSON.stringify(dataRequest),
            };

            const self = this;

            let request = new XMLHttpRequest();
            request.open('POST', this.core.url, true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            request.onload = function () {
                if (this.status >= 200 && this.status < 400) {
                    try {
                        const result = JSON.parse(this.response);
                        self.linkPublicEl.value = result.public_link;
                    } catch (e) {
                        console.log(this.response);
                        console.log('Response not json.')
                        return false;
                    }

                    let cookieName = 'link-' + dataRequest.postId;

                    Cookies.set(cookieName, true, {
                        expires: 7,
                        path: '/'
                    });

                    alert('Link added');

                } else {
                    alert('Link not added');
                }
            };
            request.onerror = function() {
                alert('Get link error');
            };
            request.send(this.encodeURI(dataSend));

            return undefined;
        }

        this.btn.addEventListener('click', ev => getLink(ev));
    }

    encodeURI(obj: object) {
        let result = '';
        let splitter = '';
        if (typeof obj === 'object') {
            Object.keys(obj).forEach(function (key) {
                result += splitter + key + '=' + encodeURIComponent(obj[key]);
                splitter = '&';
            });
        }
        return result;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    new VideoLink();
})