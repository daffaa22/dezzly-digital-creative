import react from '@vitejs/plugin-react'
import { defineConfig } from 'vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    host: true, // Membuka akses untuk semua perangkat di satu jaringan (LAN / Wi-Fi)
    port: 5173,
    cors: true
  }
})
