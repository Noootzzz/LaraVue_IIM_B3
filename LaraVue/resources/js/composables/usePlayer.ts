import { ref } from 'vue';

interface Track {
    id: number;
    title: string;
    artist: string;
    image: string;
    audio: string;
    slug: string;
}

const currentTrack = ref<Track | null>(null);
const isPlaying = ref(false);
const audio = ref<HTMLAudioElement | null>(null);

export function usePlayer() {
    const play = (track: Track) => {
        if (currentTrack.value?.id !== track.id) {
            if (audio.value) {
                audio.value.pause();
            }
            currentTrack.value = track;
            audio.value = new Audio(`/storage/${track.audio}`);
            audio.value.onended = () => {
                isPlaying.value = false;
            };
        }

        audio.value?.play();
        isPlaying.value = true;
    };

    const pause = () => {
        if (audio.value) {
            audio.value.pause();
            isPlaying.value = false;
        }
    };

    const togglePlay = () => {
        if (isPlaying.value) {
            pause();
        } else {
            if (currentTrack.value) {
                audio.value?.play();
                isPlaying.value = true;
            }
        }
    };

    return {
        currentTrack,
        isPlaying,
        play,
        pause,
        togglePlay,
    };
}
