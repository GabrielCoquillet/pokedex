import requests,pymysql.cursors

conn = pymysql.connect(
host = "localhost",
user = "root",
password = "root",
database = "pokedex"
)

def tri(nom):
    nvnom = ""
    for elt in nom :
        if elt != "♀" and elt != "♂":
            nvnom = nvnom+elt
    return nvnom

with conn:
    for i in range(1,1026):
        response = requests.get(f"https://tyradex.app/api/v1/pokemon/{i}")
        data = response.json()
        print(data['name']['fr'])
        with conn.cursor() as cursor:
            sql = "SELECT id FROM categorie WHERE nom=%s"
            cursor.execute(sql,(data['category']))
            cat_id = cursor.fetchone()[0]
            sql = "INSERT INTO pokemon VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
            cursor.execute(sql,
            (int(data['pokedex_id']),
            tri(data['name']['fr']),
            data['sprites']['regular'],
            cat_id,
            data['height'],
            data['weight'],
            int(data['stats']['hp']),
            int(data['stats']['atk']),
            int(data['stats']['def']),
            int(data['stats']['vit']),
            data['sprites']['shiny'])
            )
            conn.commit()
