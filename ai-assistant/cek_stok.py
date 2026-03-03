import requests

def asisten_ai():
    print("Halo! Saya Asisten AI Toko Baju Amin Jaya.")
    perintah = input("Mau tanya stok apa? (Contoh: kaos): ").lower()

    # Mengambil data dari API Laravel
    response = requests.get("http://127.0.0.1:8000/api/baju")
    data = response.json()['data']

    # Logika NLP Sederhana (Mencari kata kunci dalam data)
    ditemukan = False
    for item in data:
        # Jika kata kunci ada di dalam nama baju
        if perintah in item['nama_baju'].lower():
            print(f"✅ Stok {item['nama_baju']} (Ukuran {item['ukuran']}) sisa {item['stok']} pcs.")
            ditemukan = True
    
    if not ditemukan:
        print(f"❌ Maaf, barang dengan kata kunci '{perintah}' tidak ditemukan.")

if __name__ == "__main__":
    asisten_ai()