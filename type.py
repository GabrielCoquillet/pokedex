import requests,pymysql.cursors

conn = pymysql.connect(
host = "localhost",
user = "root",
password = "root",
database = "pokedex"
)

s = set()

for i in range(1,1026):
    response = requests.get(f"https://tyradex.app/api/v1/pokemon/{i}")
    data = response.json()
    if data["category"] not in s:
        s.add(data["types"][0]["name"])
print(s)

with conn:
    i = 1
    for elt in s:
        print(elt)
        with conn.cursor() as cursor:
            sql = "INSERT INTO type(id,nom) VALUES (%s, %s)"
            cursor.execute(sql, (i, elt))
            conn.commit()
        i+=1