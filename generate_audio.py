import os
import wave
import struct
import math
import random

os.makedirs('public/audio', exist_ok=True)
output_path = 'public/audio/the-weeknd.wav'

sample_rate = 44100
bpm = 171
beat_sec = 60.0 / bpm            # ~0.3508s
sixteenth_sec = beat_sec / 4.0   # ~0.0877s
num_bars = 16                    # 64 beats = 22.45 seconds loop
total_time = num_bars * 4 * beat_sec
total_samples = int(total_time * sample_rate)

# Allocate stereo buffers
left_buf = [0.0] * total_samples
right_buf = [0.0] * total_samples

# Note frequencies (Hz)
F3 = 174.61
G3 = 196.00
Ab3 = 207.65
Bb3 = 233.08
C4 = 261.63
Eb4 = 311.13
F4 = 349.23
G4 = 392.00
Ab4 = 415.30
Bb4 = 466.16
C5 = 523.25

# 4-bar chord progression: Fm -> Cm -> Eb -> Bb (repeats 4 times)
# Lead melody 32-step sixteenth-note pattern for 4 bars (The Weeknd - Blinding Lights hook)
melody_pattern = [
    # Bar 1: Fm
    (0, F4, 0.22), (2, F4, 0.15), (3, G4, 0.15), (4, F4, 0.22), (6, Eb4, 0.15), (7, C4, 0.25),
    # Bar 2: Cm
    (8, C4, 0.22), (10, C4, 0.15), (11, Eb4, 0.15), (12, C4, 0.22), (14, Ab3, 0.15), (15, F3, 0.25),
    # Bar 3: Eb
    (16, Eb4, 0.22), (18, Eb4, 0.15), (19, F4, 0.15), (20, Eb4, 0.22), (22, C4, 0.15), (23, Ab3, 0.25),
    # Bar 4: Bb
    (24, Bb3, 0.22), (26, Bb3, 0.15), (27, C4, 0.15), (28, Bb3, 0.22), (30, F3, 0.15), (31, Ab3, 0.25),
]

# Bass root note for each of the 4 bars
bass_roots = [
    87.31,  # F1 (Bar 1)
    65.41,  # C1 (Bar 2)
    77.78,  # Eb1 (Bar 3)
    58.27,  # Bb0 (Bar 4)
]

def add_synth_note(start_time, duration, freq, volume=0.35, pan=0.0):
    start_sample = int(start_time * sample_rate)
    end_sample = min(total_samples, start_sample + int(duration * sample_rate))
    
    pan_l = math.cos((pan + 1.0) * math.pi / 4.0)
    pan_r = math.sin((pan + 1.0) * math.pi / 4.0)

    for i in range(start_sample, end_sample):
        t = (i - start_sample) / sample_rate
        # Envelope: Attack 0.015s, Decay to 0.7, Release
        if t < 0.015:
            env = t / 0.015
        elif t < duration * 0.7:
            env = 1.0 - 0.25 * ((t - 0.015) / (duration * 0.7))
        else:
            rel_t = (t - duration * 0.7) / (duration * 0.3)
            env = 0.75 * max(0.0, 1.0 - rel_t)

        # Rich multi-oscillator synth (Sawtooth + Pulse + Detuned sub-octave)
        phase1 = (t * freq) % 1.0
        saw1 = 2.0 * phase1 - 1.0

        # Detuned saw (+4 cents)
        phase2 = (t * freq * 1.0025) % 1.0
        saw2 = 2.0 * phase2 - 1.0

        # Sub-octave square wave
        phase_sub = (t * (freq * 0.5)) % 1.0
        sub_sq = 0.8 if phase_sub < 0.5 else -0.8

        sample_val = (0.5 * saw1 + 0.35 * saw2 + 0.25 * sub_sq) * env * volume

        left_buf[i] += sample_val * pan_l
        right_buf[i] += sample_val * pan_r

def add_bass_note(start_time, duration, root_freq, volume=0.45):
    start_sample = int(start_time * sample_rate)
    end_sample = min(total_samples, start_sample + int(duration * sample_rate))

    for i in range(start_sample, end_sample):
        t = (i - start_sample) / sample_rate
        # Punchy 80s bass envelope
        env = math.exp(-t * 22.0)

        # Fundamental + strong 2nd & 3rd harmonics (so it cuts through phone/laptop speakers)
        f1 = root_freq
        f2 = root_freq * 2.0
        f3 = root_freq * 3.0

        sig = (math.sin(2.0 * math.pi * f1 * t) * 0.45 +
               math.sin(2.0 * math.pi * f2 * t) * 0.35 +
               math.sin(2.0 * math.pi * f3 * t) * 0.20)

        val = sig * env * volume
        left_buf[i] += val * 0.75
        right_buf[i] += val * 0.75

def add_kick(start_time, volume=0.65):
    start_sample = int(start_time * sample_rate)
    dur = 0.12
    end_sample = min(total_samples, start_sample + int(dur * sample_rate))

    for i in range(start_sample, end_sample):
        t = (i - start_sample) / sample_rate
        # Pitch drop 150Hz -> 45Hz
        freq = 45.0 + 105.0 * math.exp(-t * 35.0)
        phase = 2.0 * math.pi * (45.0 * t - (105.0 / 35.0) * (math.exp(-t * 35.0) - 1.0))
        env = math.exp(-t * 18.0)
        val = math.sin(phase) * env * volume
        left_buf[i] += val
        right_buf[i] += val

def add_snare(start_time, volume=0.55):
    start_sample = int(start_time * sample_rate)
    dur = 0.18
    end_sample = min(total_samples, start_sample + int(dur * sample_rate))

    for i in range(start_sample, end_sample):
        t = (i - start_sample) / sample_rate
        body = math.sin(2.0 * math.pi * 185.0 * t) * math.exp(-t * 28.0)
        noise = (random.random() * 2.0 - 1.0) * math.exp(-t * 15.0)
        val = (0.35 * body + 0.65 * noise) * volume
        left_buf[i] += val * 0.85
        right_buf[i] += val * 0.85

def add_hihat(start_time, volume=0.25, open_hat=False):
    start_sample = int(start_time * sample_rate)
    dur = 0.12 if open_hat else 0.04
    decay = 18.0 if open_hat else 65.0
    end_sample = min(total_samples, start_sample + int(dur * sample_rate))

    for i in range(start_sample, end_sample):
        t = (i - start_sample) / sample_rate
        noise = (random.random() * 2.0 - 1.0) * math.exp(-t * decay)
        val = noise * volume
        left_buf[i] += val * 0.9
        right_buf[i] += val * 0.7

print("Synthesizing 80s Synthwave track (The Weeknd Vibe)...")

# Render drums, bass, and lead across all bars
for bar in range(num_bars):
    bar_start_time = bar * 4 * beat_sec
    prog_bar = bar % 4
    root = bass_roots[prog_bar]

    # 1. Four-on-the-floor Kick & Snare
    for b in range(4):
        beat_time = bar_start_time + b * beat_sec
        add_kick(beat_time, volume=0.6)
        if b % 2 == 1:
            add_snare(beat_time, volume=0.5)

    # 2. 16th-note Hi-hats
    for s in range(16):
        s_time = bar_start_time + s * sixteenth_sec
        is_open = (s % 4 == 2)
        add_hihat(s_time, volume=0.22 if is_open else 0.14, open_hat=is_open)

    # 3. 16th-note Driving Analog Bassline (Octave bouncing)
    for s in range(16):
        b_time = bar_start_time + s * sixteenth_sec
        # Octave up on odd 16th notes (classic 80s Italo / Synthwave bass)
        freq = root * 2.0 if (s % 2 == 1) else root
        add_bass_note(b_time, sixteenth_sec * 0.9, freq, volume=0.48)

    # 4. Melodic Lead Hook (Repeats every 4 bars)
    for step_idx, note_freq, dur in melody_pattern:
        pattern_bar = step_idx // 8
        if pattern_bar == prog_bar:
            step_in_bar = step_idx % 8
            # Each step is 2 sixteenth notes (eighth-note grid)
            note_time = bar_start_time + (step_in_bar * 2) * sixteenth_sec
            pan_val = -0.2 if (step_idx % 2 == 0) else 0.2
            add_synth_note(note_time, dur, note_freq, volume=0.42, pan=pan_val)

# Normalize audio to prevent clipping and ensure loud, punchy clarity
max_val = max(max(abs(x) for x in left_buf), max(abs(y) for y in right_buf))
if max_val > 0.001:
    gain = 0.92 / max_val
    print(f"Normalizing audio (Peak: {max_val:.3f}, Gain: {gain:.3f})...")
    left_buf = [x * gain for x in left_buf]
    right_buf = [y * gain for y in right_buf]

# Write to WAV file
with wave.open(output_path, 'wb') as wav_file:
    wav_file.setnchannels(2)
    wav_file.setsampwidth(2) # 16-bit
    wav_file.setframerate(sample_rate)

    frames = bytearray()
    for l, r in zip(left_buf, right_buf):
        l_clamped = max(-1.0, min(1.0, l))
        r_clamped = max(-1.0, min(1.0, r))
        l_int = int(l_clamped * 32767.0)
        r_int = int(r_clamped * 32767.0)
        frames.extend(struct.pack('<hh', l_int, r_int))

    wav_file.writeframes(frames)

file_size_kb = os.path.getsize(output_path) / 1024
print(f"Success! Output written to {output_path} ({file_size_kb:.1f} KB)")

