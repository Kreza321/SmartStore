from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
import requests

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

class Query(BaseModel):
    text: str

@app.post("/proses")
async def proses_ai(query: Query):
    # Bersihkan input user
    raw_text = query.text.lower()
    
    # List kata-kata yang biasanya cuma basa-basi (noise words)
    ignore_words = ["cek", "stok", "stock", "ada", "gak", "dong", "apa", "berapa", "cari", "tanya", "si", "juki"]
    
    # Ambil kata-kata penting dari kalimat user
    words = raw_text.split()
    keywords = [w for w in words if w not in ignore_words]
    
    # Backup: Mapping typo atau kata gaul yang sangat spesifik
    gaul_map = {
        "clana": "celana", 
        "hcn": "h&m"
    }
    
    # Update keywords jika ada di gaul_map
    keywords = [gaul_map.get(w, w) for w in keywords]

    if not keywords:
        return {"reply": "Hah? Ngomong apaan lu? Kagak paham gue. Coba tanya stok baju yang bener nape!"}

    try:
        # Panggil API Laravel
        res = requests.get("http://127.0.0.1:8000/api/baju")
        data = res.json()['data']
        
        found = []
        # Cari kecocokan kata kunci di Brand, Nama Baju, atau Kategori
        for item in data:
            item_data = f"{item['nama_baju']} {item['brand']} {item['kategori']}".lower()
            if any(key in item_data for key in keywords):
                found.append(item)
                
        if found:
            i = found[0] # Ambil hasil pertama yang paling cocok
            return {
                "reply": f"Huwala! Nih gue cariin, buat brand {i['brand']}, stok {i['nama_baju']} ukuran {i['ukuran']} sisa {i['stok']} biji lagi. Sikat miring!"
            }
                
        return {"reply": f"Yah elah, barang yang lu cari lagi kaga ada di gudang. Lu telat sih!"}
    
    except Exception as e:
        print(f"Error: {e}")
        return {"reply": "Aduh, servernya lagi puyeng nih, kaga bisa nanya ke database!"}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=5000)