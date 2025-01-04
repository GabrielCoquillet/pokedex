import requests,pymysql.cursors

conn = pymysql.connect(host = "localhost",user = "root",password = "root",database = "pokedex")


data = requests.get("https://tyradex.vercel.app/api/v1/pokemon")
data = data.json()

def tri(nom):
    nvnom = ""
    for elt in nom :
        if elt != "♀" and elt != "♂":
            nvnom = nvnom+elt
    return nvnom

def pokemon(data):
    for i in range(1, 1026):
        with conn.cursor() as cursor:
            sql = "SELECT id FROM categorie WHERE nom=%s"
            cursor.execute(sql,(data[i]['category']))
            cat_id = cursor.fetchone()[0]
            sql = "INSERT INTO pokemon VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
            cursor.execute(sql,
            (int(data[i]['pokedex_id']),
            tri(data[i]['name']['fr']),
            data[i]['sprites']['regular'],
            cat_id,
            data[i]['height'],
            data[i]['weight'],
            int(data[i]['stats']['hp']),
            int(data[i]['stats']['atk']),
            int(data[i]['stats']['def']),
            int(data[i]['stats']['vit']),
            data[i]['sprites']['shiny'])
            )
            conn.commit()

def categorie(data):
    s = set()
    for i in range(1, 1026):
        if data[i]["category"] not in s:
            s.add(data[i]["category"])

    with conn:
        i = 1
        for elt in s:
            print(elt)
            with conn.cursor() as cursor:
                sql = "INSERT INTO categorie(id,nom) VALUES (%s, %s)"
                cursor.execute(sql, (i, elt))
                conn.commit()
            i += 1

def type(data):
    s = set()
    for i in range(1, 1026):
        for elt in data[i]['types']:
            if elt['name'] not in s:
                s.add(elt['name'])
    with conn:
        i = 1
        for elt in s:
            print(elt)
            with conn.cursor() as cursor:
                sql = "INSERT INTO type(id,nom) VALUES (%s, %s)"
                cursor.execute(sql, (i, elt))
                conn.commit()
            i += 1

def generation(data):
    s = set()
    for i in range(1,1026):
        if data[i]['generation'] not in s:
            s.add(data[i]['generation'])

    with conn:
        for elt in s:
            with conn.cursor() as cursor:
                sql = "INSERT INTO generation VALUES (%s, %s)"
                cursor.execute(sql, (elt, f"generation {elt}"))
                conn.commit()

def region(data):
    s = set()
    for i in range(1,1026):
        if data[i]['formes'] is not None:
            for elt in data[i]['formes']:
                if elt['region'] not in s:
                    s.add(elt['region'])

    with conn:
        i = 1
        for elt in s:
            print(elt)
            with conn.cursor() as cursor:
                sql = "INSERT INTO region(id,nom) VALUES (%s, %s)"
                cursor.execute(sql, (i, elt))
                conn.commit()
            i += 1

def famille(data):
    for i in range(1,1026):
        print(data[i]['pokedex_id'])
        if data[i]['evolution'] is not None and data[i]['evolution']['pre'] is None:
            id_base = data[i]['pokedex_id']
            li_id_next = []
            if data[i]['evolution']['next'] is not None:
                for elt in data[i]['evolution']['next']:
                    li_id_next.append(elt['pokedex_id'])
                id_level_max = data[i]['evolution']['mega']
                id_level_2 = li_id_next.pop(0)
                if len(li_id_next) != 0:
                    id_level_3 = li_id_next.pop(0)
                    with conn.cursor() as cursor:
                        sql = "INSERT INTO famille(id_pokemon_base,id_pokemon_level_2, id_pokemon_level_3, id_pokemon_ex) VALUES (%s, %s, %s, %s)"
                        cursor.execute(sql, (id_base, id_level_2, id_level_3, id_level_max))
                        conn.commit()
                else:
                    with conn.cursor() as cursor:
                        sql = "INSERT INTO famille(id_pokemon_base,id_pokemon_level_2, id_pokemon_ex) VALUES (%s, %s, %s)"
                        cursor.execute(sql, (id_base, id_level_2, id_level_max))
                        conn.commit()

def link_faiblesse(data):
    for i in range(1,1026):
        for elt in data[i]['resistances']:
            if elt['multiplier'] == 2:
                with conn.cursor() as cursor:
                    sql = "SELECT id FROM type WHERE nom=%s"
                    cursor.execute(sql, (elt['name']))
                    id_type = cursor.fetchone()[0]

                with conn.cursor() as cursor:
                    sql = "INSERT INTO link_faiblesse(id_pokemon,id_type) VALUES (%s, %s)"
                    cursor.execute(sql, (data[i]['pokedex_id'], id_type))
                    conn.commit()

def link_generation(data):
    pass

def link_region(data):
    for i in range(1, 1026):
        if data[i]['formes'] is not None:
            for elt in data[i]['formes']:
                with conn.cursor() as cursor:
                    sql = "SELECT id FROM region WHERE nom=%s"
                    cursor.execute(sql, (elt['region']))
                    id_region = cursor.fetchone()[0]

                with conn.cursor() as cursor:
                    sql = "INSERT INTO link_region(id_pokemon,id_region) VALUES (%s, %s)"
                    cursor.execute(sql, (data[i]['pokedex_id'], id_region))
                    conn.commit()

def link_type(data):
    for i in range(1,1026):
        for elt in data[i]['types']:
            with conn.cursor() as cursor:
                sql = "SELECT id FROM type WHERE nom=%s"
                cursor.execute(sql, (elt['name']))
                type_id = cursor.fetchone()[0]

            with conn.cursor() as cursor:
                sql = "INSERT INTO link_type(id_type, id_pokemon) VALUES (%s, %s)"
                cursor.execute(sql, (type_id, data[i]['pokedex_id']))
                conn.commit()

#generation(data)
#type(data)
#categorie(data)
#pokemon(data)
#region(data)
#famille(data)
#link_type(data)
#link_region(data)
link_faiblesse(data)