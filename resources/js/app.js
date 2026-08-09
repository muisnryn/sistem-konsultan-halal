
import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Daftarkan plugin & taruh di window supaya bisa dipakai
// langsung oleh script inline di welcome.blade.php
gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

window.Alpine = Alpine;
Alpine.start();
