/**
 * Dezzly Creative - The Weeknd Studio Vibes & Interactive Audio Engine
 * Features:
 * 1. Dedicated Dual Audio Engine: High-fidelity Studio Audio file with Procedural Synthesizer fallback
 * 2. Visualizer audio bars animation synced to playback state
 * 3. Interactive Camera Shutter click sound for buttons and cards
 */

class DezzlyAudioEngine {
    constructor() {
        this.isPlaying = false;
        this.volume = 0.8;
        this.audioElement = null;
        this.audioCtx = null;
        this.synthTimer = null;
        this.step = 0;

        // Auto-detect HTML5 audio element
        if (typeof document !== 'undefined') {
            document.addEventListener('DOMContentLoaded', () => {
                this.bindAudioElement();
            });
        }
    }

    bindAudioElement() {
        let el = document.getElementById('dezzly-bg-audio');
        if (!el) {
            el = new Audio('/audio/the-weeknd.wav');
            el.loop = true;
        }
        el.volume = this.volume;
        this.audioElement = el;

        // Sync state if audio ends or pauses externally
        el.addEventListener('play', () => {
            this.isPlaying = true;
            this.updateWidgetState(true);
        });
        el.addEventListener('pause', () => {
            this.isPlaying = false;
            this.updateWidgetState(false);
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
     * Play subtle camera shutter sound on click micro-interactions
     */
    playShutterSound() {
        try {
            const ctx = this.getAudioContext();
            if (!ctx) return;

            const now = ctx.currentTime;
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            osc.type = 'triangle';
            osc.frequency.setValueAtTime(850, now);
            osc.frequency.exponentialRampToValueAtTime(140, now + 0.05);

            gain.gain.setValueAtTime(this.volume * 0.45, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.06);

            osc.connect(gain);
            gain.connect(ctx.destination);

            osc.start(now);
            osc.stop(now + 0.07);

            // Shutter noise burst
            const bufferSize = ctx.sampleRate * 0.025;
            const buffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
            const output = buffer.getChannelData(0);
            for (let i = 0; i < bufferSize; i++) {
                output[i] = Math.random() * 2 - 1;
            }
            const whiteNoise = ctx.createBufferSource();
            whiteNoise.buffer = buffer;

            const noiseFilter = ctx.createBiquadFilter();
            noiseFilter.type = 'bandpass';
            noiseFilter.frequency.value = 1400;

            const noiseGain = ctx.createGain();
            noiseGain.gain.setValueAtTime(this.volume * 0.35, now + 0.015);
            noiseGain.gain.exponentialRampToValueAtTime(0.001, now + 0.05);

            whiteNoise.connect(noiseFilter);
            noiseFilter.connect(noiseGain);
            noiseGain.connect(ctx.destination);

            whiteNoise.start(now + 0.015);
            whiteNoise.stop(now + 0.055);
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

        // Ensure audio context is running
        if (ctx.state === 'suspended') {
            ctx.resume();
        }

        this.stopProceduralSynth();

        const stepTimeMs = 88; // ~171 BPM sixteenth note
        const leadNotes = [
            349.23, 0, 349.23, 392.00, 349.23, 0, 311.13, 261.63,
            261.63, 0, 261.63, 311.13, 261.63, 0, 207.65, 174.61,
            311.13, 0, 311.13, 349.23, 311.13, 0, 261.63, 207.65,
            233.08, 0, 233.08, 261.63, 233.08, 0, 174.61, 207.65
        ];

        const bassNotes = [
            174.61, 174.61, 174.61, 174.61, 174.61, 174.61, 174.61, 174.61, // F2
            130.81, 130.81, 130.81, 130.81, 130.81, 130.81, 130.81, 130.81, // C2
            155.56, 155.56, 155.56, 155.56, 155.56, 155.56, 155.56, 155.56, // Eb2
            116.54, 116.54, 116.54, 116.54, 116.54, 116.54, 116.54, 116.54  // Bb1
        ];

        this.step = 0;

        this.synthTimer = setInterval(() => {
            if (!this.isPlaying) return;

            const now = ctx.currentTime;
            const currentStep = this.step % 32;

            // 1. Synth Bass Note
            const bassFreq = bassNotes[currentStep];
            if (bassFreq > 0) {
                const bassOsc = ctx.createOscillator();
                const bassFilter = ctx.createBiquadFilter();
                const bassGain = ctx.createGain();

                bassOsc.type = 'sawtooth';
                bassOsc.frequency.setValueAtTime(bassFreq, now);

                bassFilter.type = 'lowpass';
                bassFilter.frequency.setValueAtTime(800, now);
                bassFilter.frequency.exponentialRampToValueAtTime(300, now + 0.08);

                bassGain.gain.setValueAtTime(this.volume * 0.75, now);
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
                leadFilter.frequency.setValueAtTime(2400, now);
                leadFilter.frequency.exponentialRampToValueAtTime(900, now + 0.12);

                leadGain.gain.setValueAtTime(this.volume * 0.65, now);
                leadGain.gain.exponentialRampToValueAtTime(0.001, now + 0.14);

                leadOsc.connect(leadFilter);
                leadFilter.connect(leadGain);
                leadGain.connect(ctx.destination);

                leadOsc.start(now);
                leadOsc.stop(now + 0.15);
            }

            // 3. 80s Drum Beat
            if (currentStep % 8 === 0) {
                const kickOsc = ctx.createOscillator();
                const kickGain = ctx.createGain();
                kickOsc.frequency.setValueAtTime(160, now);
                kickOsc.frequency.exponentialRampToValueAtTime(50, now + 0.07);
                kickGain.gain.setValueAtTime(this.volume * 0.8, now);
                kickGain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);
                kickOsc.connect(kickGain);
                kickGain.connect(ctx.destination);
                kickOsc.start(now);
                kickOsc.stop(now + 0.09);
            } else if (currentStep % 8 === 4) {
                const snareOsc = ctx.createOscillator();
                const snareGain = ctx.createGain();
                snareOsc.type = 'triangle';
                snareOsc.frequency.setValueAtTime(240, now);
                snareOsc.frequency.exponentialRampToValueAtTime(90, now + 0.05);
                snareGain.gain.setValueAtTime(this.volume * 0.6, now);
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
        this.isPlaying = true;
        this.getAudioContext();

        if (!this.audioElement) {
            this.bindAudioElement();
        }

        if (this.audioElement) {
            this.audioElement.volume = this.volume;
            const playPromise = this.audioElement.play();
            if (playPromise !== undefined) {
                playPromise.catch((err) => {
                    console.warn('[DezzlyAudio] Audio file play blocked or unavailable, using Web Audio Synth:', err);
                    this.startProceduralSynth();
                });
            }
        } else {
            this.startProceduralSynth();
        }

        this.updateWidgetState(true);
    }

    pause() {
        this.isPlaying = false;
        if (this.audioElement) {
            this.audioElement.pause();
        }
        this.stopProceduralSynth();
        this.updateWidgetState(false);
    }

    setVolume(val) {
        this.volume = Math.max(0, Math.min(1, val));
        if (this.audioElement) {
            this.audioElement.volume = this.volume;
        }
    }

    updateWidgetState(playing) {
        const widget = document.getElementById('music-player-widget');
        if (widget && window.Alpine) {
            try {
                const data = window.Alpine.$data(widget);
                if (data && data.isPlaying !== playing) {
                    data.isPlaying = playing;
                }
            } catch (e) {
                // Alpine data not ready
            }
        }
    }
}

// Global instance
window.dezzlyAudio = new DezzlyAudioEngine();

// Hook camera shutter clicks to buttons
if (typeof document !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('button:not(#music-player-widget button), a[href^="#rental"]').forEach((el) => {
            el.addEventListener('click', () => {
                if (window.dezzlyAudio) {
                    window.dezzlyAudio.playShutterSound();
                }
            });
        });
    });
}
