/**
 * Dezzly Creative - The Weeknd Studio Vibes & Interactive Audio Engine
 * Features:
 * 1. Dual Audio Engine: Plays /audio/the-weeknd.mp3 if available, or procedural 80s Synthwave synthesizer (Blinding Lights style)
 * 2. Visualizer audio bars animation
 * 3. Interactive Camera Shutter click sound
 */

class DezzlyAudioEngine {
    constructor() {
        this.isPlaying = false;
        this.audioCtx = null;
        this.synthTimer = null;
        this.step = 0;
        this.volume = 0.35;
        this.audioElement = null;
        this.hasExternalAudio = false;

        this.initExternalAudio();
    }

    initExternalAudio() {
        this.audioElement = new Audio('/audio/the-weeknd.mp3');
        this.audioElement.loop = true;
        this.audioElement.volume = this.volume;

        this.audioElement.addEventListener('canplaythrough', () => {
            this.hasExternalAudio = true;
        });
        this.audioElement.addEventListener('error', () => {
            this.hasExternalAudio = false;
        });
    }

    getAudioContext() {
        if (!this.audioCtx) {
            const AudioCtxClass = window.AudioContext || window.webkitAudioContext;
            if (AudioCtxClass) {
                this.audioCtx = new AudioCtxClass();
            }
        }
        if (this.audioCtx && this.audioCtx.state === 'suspended') {
            this.audioCtx.resume();
        }
        return this.audioCtx;
    }

    /**
     * Play Camera Shutter Click sound for micro-interactions
     */
    playShutterSound() {
        try {
            const ctx = this.getAudioContext();
            if (!ctx) return;

            const now = ctx.currentTime;
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            osc.type = 'triangle';
            osc.frequency.setValueAtTime(800, now);
            osc.frequency.exponentialRampToValueAtTime(120, now + 0.05);

            gain.gain.setValueAtTime(this.volume * 0.4, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.06);

            osc.connect(gain);
            gain.connect(ctx.destination);

            osc.start(now);
            osc.stop(now + 0.07);

            // Click noise burst
            const bufferSize = ctx.sampleRate * 0.03;
            const buffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
            const output = buffer.getChannelData(0);
            for (let i = 0; i < bufferSize; i++) {
                output[i] = Math.random() * 2 - 1;
            }
            const whiteNoise = ctx.createBufferSource();
            whiteNoise.buffer = buffer;

            const noiseFilter = ctx.createBiquadFilter();
            noiseFilter.type = 'bandpass';
            noiseFilter.frequency.value = 1200;

            const noiseGain = ctx.createGain();
            noiseGain.gain.setValueAtTime(this.volume * 0.3, now + 0.02);
            noiseGain.gain.exponentialRampToValueAtTime(0.001, now + 0.05);

            whiteNoise.connect(noiseFilter);
            noiseFilter.connect(noiseGain);
            noiseGain.connect(ctx.destination);

            whiteNoise.start(now + 0.02);
            whiteNoise.stop(now + 0.06);
        } catch (e) {
            // Audio context not ready
        }
    }

    /**
     * Procedural 80s Synthwave Generator (The Weeknd - Blinding Lights style: Fm -> Cm -> Eb -> Bb)
     */
    startProceduralSynth() {
        const ctx = this.getAudioContext();
        if (!ctx) return;

        // Tempo: 171 BPM, sixteenth note step ~ 87.7ms
        const stepTimeMs = 88;

        // F minor pentatonic / synth bass notes frequencies (Hz)
        // Fm: F (174.6), Ab (207.6), C (261.6), Eb (311.1), F2 (349.2), G (392)
        const leadNotes = [
            349.23, 0, 349.23, 392.00, 349.23, 0, 311.13, 261.63,
            261.63, 0, 261.63, 311.13, 261.63, 0, 207.65, 174.61,
            311.13, 0, 311.13, 349.23, 311.13, 0, 261.63, 207.65,
            233.08, 0, 233.08, 261.63, 233.08, 0, 174.61, 207.65
        ];

        const bassNotes = [
            87.31, 87.31, 87.31, 87.31, 87.31, 87.31, 87.31, 87.31, // F1
            65.41, 65.41, 65.41, 65.41, 65.41, 65.41, 65.41, 65.41, // C1
            77.78, 77.78, 77.78, 77.78, 77.78, 77.78, 77.78, 77.78, // Eb1
            58.27, 58.27, 58.27, 58.27, 58.27, 58.27, 58.27, 58.27  // Bb0
        ];

        this.step = 0;

        this.synthTimer = setInterval(() => {
            if (!this.isPlaying) return;

            const now = ctx.currentTime;
            const currentStep = this.step % 32;

            // 1. Synth Bass Note (Pulsing 80s analog bass)
            const bassFreq = bassNotes[currentStep];
            if (bassFreq > 0) {
                const bassOsc = ctx.createOscillator();
                const bassFilter = ctx.createBiquadFilter();
                const bassGain = ctx.createGain();

                bassOsc.type = 'sawtooth';
                bassOsc.frequency.setValueAtTime(bassFreq, now);

                bassFilter.type = 'lowpass';
                bassFilter.frequency.setValueAtTime(450, now);
                bassFilter.frequency.exponentialRampToValueAtTime(180, now + 0.08);

                bassGain.gain.setValueAtTime(this.volume * 0.45, now);
                bassGain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);

                bassOsc.connect(bassFilter);
                bassFilter.connect(bassGain);
                bassGain.connect(ctx.destination);

                bassOsc.start(now);
                bassOsc.stop(now + 0.085);
            }

            // 2. Synth Lead Melody (80s Poly Lead)
            const leadFreq = leadNotes[currentStep];
            if (leadFreq > 0) {
                const leadOsc = ctx.createOscillator();
                const leadFilter = ctx.createBiquadFilter();
                const leadGain = ctx.createGain();

                leadOsc.type = 'sawtooth';
                leadOsc.frequency.setValueAtTime(leadFreq, now);

                leadFilter.type = 'lowpass';
                leadFilter.frequency.setValueAtTime(1800, now);
                leadFilter.frequency.exponentialRampToValueAtTime(600, now + 0.12);

                leadGain.gain.setValueAtTime(this.volume * 0.28, now);
                leadGain.gain.exponentialRampToValueAtTime(0.001, now + 0.14);

                leadOsc.connect(leadFilter);
                leadFilter.connect(leadGain);
                leadGain.connect(ctx.destination);

                leadOsc.start(now);
                leadOsc.stop(now + 0.15);
            }

            // 3. 80s Drum Beat (Kick on 0, 8, 16, 24 | Snare on 4, 12, 20, 28)
            if (currentStep % 8 === 0) {
                // Kick drum
                const kickOsc = ctx.createOscillator();
                const kickGain = ctx.createGain();
                kickOsc.frequency.setValueAtTime(140, now);
                kickOsc.frequency.exponentialRampToValueAtTime(45, now + 0.07);
                kickGain.gain.setValueAtTime(this.volume * 0.5, now);
                kickGain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);
                kickOsc.connect(kickGain);
                kickGain.connect(ctx.destination);
                kickOsc.start(now);
                kickOsc.stop(now + 0.09);
            } else if (currentStep % 8 === 4) {
                // Snare drum (white noise + pop)
                const snareOsc = ctx.createOscillator();
                const snareGain = ctx.createGain();
                snareOsc.type = 'triangle';
                snareOsc.frequency.setValueAtTime(220, now);
                snareOsc.frequency.exponentialRampToValueAtTime(80, now + 0.05);
                snareGain.gain.setValueAtTime(this.volume * 0.3, now);
                snareGain.gain.exponentialRampToValueAtTime(0.001, now + 0.06);
                snareOsc.connect(snareGain);
                snareGain.connect(ctx.destination);
                snareOsc.start(now);
                snareOsc.stop(now + 0.07);
            }

            this.step++;
        }, stepTimeMs);
    }

    stopProceduralSynth() {
        if (this.synthTimer) {
            clearInterval(this.synthTimer);
            this.synthTimer = null;
        }
    }

    togglePlay() {
        if (this.isPlaying) {
            this.pause();
        } else {
            this.play();
        }
        return this.isPlaying;
    }

    play() {
        this.getAudioContext();
        this.isPlaying = true;

        if (this.hasExternalAudio && this.audioElement) {
            this.audioElement.play().catch(() => {
                // Fallback to procedural synth
                this.startProceduralSynth();
            });
        } else {
            this.startProceduralSynth();
        }
    }

    pause() {
        this.isPlaying = false;
        if (this.audioElement) {
            this.audioElement.pause();
        }
        this.stopProceduralSynth();
    }

    setVolume(val) {
        this.volume = Math.max(0, Math.min(1, val));
        if (this.audioElement) {
            this.audioElement.volume = this.volume;
        }
    }
}

// Attach globally
window.dezzlyAudio = new DezzlyAudioEngine();

// Hook camera shutter clicks to all camera buttons
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-camera-shutter], button, .card-clean').forEach((el) => {
        el.addEventListener('click', () => {
            if (window.dezzlyAudio && !el.closest('#music-player-widget')) {
                // subtle shutter feedback
                window.dezzlyAudio.playShutterSound();
            }
        });
    });
});

