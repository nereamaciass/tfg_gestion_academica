import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    if (!window.userId) return;

    const chatBox = document.getElementById('chatBox');

    const onlineDot = document.getElementById('onlineDot');
    const escribiendo = document.getElementById('escribiendo');
    const estadoUsuario = document.getElementById('estadoUsuario');

    window.Echo.join('online')

        .here((users) => {

            console.log('USUARIOS ONLINE:', users);

            const existe = users.find(u => u.id == window.destinatarioId);

            if (existe && onlineDot) {

                onlineDot.classList.remove('bg-gray-400');
                onlineDot.classList.add('bg-green-500');

                if (estadoUsuario) {
                    estadoUsuario.textContent = 'En línea';
                }

            }

        })

        .joining((user) => {

            console.log('ENTRÓ:', user);

            if (user.id == window.destinatarioId && onlineDot) {

                onlineDot.classList.remove('bg-gray-400');
                onlineDot.classList.add('bg-green-500');

                if (estadoUsuario) {
                    estadoUsuario.textContent = 'En línea';
                }

            }

        })

        .leaving((user) => {

            console.log('SALIÓ:', user);

            if (user.id == window.destinatarioId && onlineDot) {

                onlineDot.classList.remove('bg-green-500');
                onlineDot.classList.add('bg-gray-400');

                if (estadoUsuario) {
                    estadoUsuario.textContent = 'Desconectado';
                }

            }

        })

        .error((error) => {

            console.log('ERROR ONLINE:', error);

        });

    window.Echo.private('chat.' + window.userId)

        .listen('MensajeEnviado', (e) => {

            if (
                e.mensaje.emisor_id != window.userId &&
                (
                    !window.destinatarioId ||
                    window.destinatarioId != e.mensaje.emisor_id
                )
            ) {

                Swal.fire({

                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,

                    background: '#ffffff',
                    color: '#111827',

                    customClass: {
                        popup: 'toast-chat'
                    },

                    html: `

                        <div class="flex items-center gap-3">

                            <img
                                src="https://ui-avatars.com/api/?name=${e.mensaje.emisor.name}&background=0B3C63&color=ffffff"
                                class="w-12 h-12 rounded-full object-cover border border-gray-200"
                            >

                            <div class="text-left">

                                <div class="font-semibold text-gray-900">
                                    ${e.mensaje.emisor.name}
                                </div>

                                <div class="text-sm text-gray-500 truncate max-w-[220px]">

                                    ${e.mensaje.mensaje
                                        ? e.mensaje.mensaje
                                        : '📎 Archivo adjunto'}

                                </div>

                            </div>

                        </div>

                    `

                });

            }

            const usuarioItem = document.getElementById(
                'usuario-' + e.mensaje.emisor_id
            );

            if (usuarioItem) {

                const preview = usuarioItem.querySelector('.preview-mensaje');

                if (preview) {

                    preview.innerHTML = e.mensaje.mensaje
                        ? e.mensaje.mensaje
                        : '📎 Archivo adjunto';

                }

                const hora = usuarioItem.querySelector('.hora-mensaje');

                if (hora) {

                    hora.innerHTML = 'ahora';

                }

                usuarioItem.parentNode.prepend(usuarioItem);

            }

            const esMio = e.mensaje.emisor_id == window.userId;

            let contenido = '';

            if (e.mensaje.mensaje) {

                contenido += `
                    <p class="whitespace-pre-line text-base">
                        ${e.mensaje.mensaje}
                    </p>
                `;

            }

            if (e.mensaje.archivo) {

                contenido += `
                    <a href="/storage/${e.mensaje.archivo}" target="_blank">
                        <img
                            src="/storage/${e.mensaje.archivo}"
                            class="mt-3 rounded-xl max-w-full border border-gray-200"
                        >
                    </a>
                `;

            }

            const mensajeHTML = `
                <div class="mb-4 flex animateMensaje ${esMio ? 'justify-end' : 'justify-start'}">

                    <div class="relative group max-w-[65%] px-5 py-3 shadow-sm
                        ${esMio
                            ? 'bg-blue-600 text-white rounded-2xl rounded-br-md'
                            : 'bg-white border border-gray-200 text-gray-900 rounded-2xl rounded-bl-md'}">

                        ${contenido}

                        <div class="flex items-center justify-end gap-1 mt-2">

                            <span class="text-xs ${esMio ? 'text-blue-100' : 'text-gray-500'}">
                                ahora
                            </span>

                            ${esMio
                                ? '<span class="text-xs text-blue-100">✓✓</span>'
                                : ''}

                        </div>

                    </div>

                </div>
            `;

            if (chatBox) {

                chatBox.innerHTML += mensajeHTML;

                chatBox.scrollTop = chatBox.scrollHeight;

            }

        })

        .listenForWhisper('typing', () => {

            if (!escribiendo) return;

            escribiendo.classList.remove('hidden');

            if (estadoUsuario) {
                estadoUsuario.textContent = 'Escribiendo...';
            }

            clearTimeout(window.typingTimeout);

            window.typingTimeout = setTimeout(() => {

                escribiendo.classList.add('hidden');

                if (estadoUsuario) {
                    estadoUsuario.textContent = 'En línea';
                }

            }, 1500);

        });

    const textarea = document.getElementById('mensajeInput');

    if (textarea) {

        textarea.addEventListener('input', () => {

            window.Echo.private('chat.' + window.destinatarioId)
                .whisper('typing', {
                    user: window.userId
                });

        });

    }

});