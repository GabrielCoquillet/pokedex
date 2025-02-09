import requests,pymysql.cursors

conn = pymysql.connect(host = "localhost",user = "root",password = "root",database = "pokedex")


data = requests.get("https://tyradex.vercel.app/api/v1/pokemon")
data = data.json()

def tri(nom:str)->str:
    '''
    :param nom: str
    :return: nom sans les caractères spéciaux pouvant interférer avec l'encodage de la base de données
    '''
    nvnom = ""
    for elt in nom :
        if elt != "♀" and elt != "♂":
            nvnom = nvnom+elt
    return nvnom

def pokemon(data):
    '''
        :param data: variable contenant toutes les données de l'api
        peuple la table pokemon de la base de données
    '''
    for i in range(1, 1026):
        #récupération de l'id de la catégorie du pokemon
        sql = "SELECT id FROM categorie WHERE nom=%s"
        cursor.execute(sql,(data[i]['category']))
        cat_id = cursor.fetchone()[0]

        path = 'images/sprites/'+str(data[i]['pokedex_id'])+"/regular.png"
        path_shiny='images/sprites/'+str(data[i]['pokedex_id'])+"/shiny.png"
        #insertion dans la table pokemon du tuple correspondant au pokemon
        sql = "INSERT INTO pokemon VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
        cursor.execute(sql,
        (int(data[i]['pokedex_id']),
        tri(data[i]['name']['fr']),
        path,
        cat_id,
        str(data[i]['height']),
        str(data[i]['weight']),
        int(data[i]['stats']['hp']),
        int(data[i]['stats']['atk']),
        int(data[i]['stats']['def']),
        int(data[i]['stats']['vit']),
        path_shiny,
        int(data[i]['generation']))
        )
        conn.commit()

def categorie(data):
    '''
        :param data: variable contenant toutes les données de l'api
        peuple la table categorie de la base de données
    '''
    #on récupere dans un ensemble toutes les catégories existantes
    s = set()
    for i in range(1, 1026):
        if data[i]["category"] not in s:
            s.add(data[i]["category"])

    i = 1
    for elt in s:
        #insertion de chaque catégorie existante dans la table categorie
        sql = "INSERT INTO categorie(id,nom) VALUES (%s, %s)"
        cursor.execute(sql, (i, elt))
        conn.commit()
        i += 1

def type(data):
    '''
        :param data: variable contenant toutes les données de l'api
        peuple la table type de la base de données
    '''
    # on récupere dans un ensemble tous les types existants
    s = set()
    for i in range(1, 1026):
        for elt in data[i]['types']:
            if elt['name'] not in s:
                s.add(elt['name'])
        i = 1

    for elt in s:
        #insertion de chaque type existant dans la table type
        sql = "INSERT INTO type(id,nom) VALUES (%s, %s)"
        cursor.execute(sql, (i, elt))
        conn.commit()
        i += 1

def region(data):
    '''
        :param data: variable contenant toutes les données de l'api
        peuple la table region de la base de données
    '''
    # on récupere dans un ensemble toutes les régions existantes
    s = set()
    for i in range(1,1026):
        if data[i]['formes'] is not None:
            for elt in data[i]['formes']:
                if elt['region'] not in s:
                    s.add(elt['region'])

    i = 1
    for elt in s:
        # insertion de chaque région existante dans la table region
        sql = "INSERT INTO region(id,nom) VALUES (%s, %s)"
        cursor.execute(sql, (i, elt))
        conn.commit()
        i += 1

def famille(data):
    '''
        :param data: variable contenant toutes les données de l'api
        peuple la table famille de la base de données
    '''
    for i in range(1,1026):
        #on vérifie que le pokemon est bien un pokemon de base
        if data[i]['evolution'] is not None and data[i]['evolution']['pre'] is None:
            id_base = data[i]['pokedex_id']
            li_id_next = []
            #on vérifie que le pokémon appartient bien à une famille
            if data[i]['evolution']['next'] is not None:
                for elt in data[i]['evolution']['next']:
                    #on récupère les id de toutes ses évolutions dans la liste li_id_next
                    li_id_next.append(elt['pokedex_id'])
                id_level_2 = li_id_next.pop(0)
                if len(li_id_next) != 0:
                    #dans ce cas ci, le pokémon a plus d'une évolution
                    id_level_3 = li_id_next.pop(0)
                    #insertion dans la table famille du tuple correspondant à la famille de pokemons
                    sql = "INSERT INTO famille(id_pokemon_base,id_pokemon_level_2, id_pokemon_level_3) VALUES (%s, %s, %s)"
                    cursor.execute(sql, (id_base, id_level_2, id_level_3))
                    conn.commit()
                else:
                    #dans ce cas ci, le pokémon a une seule évolution
                    #insertion dans la table famille du tuple correspondant à la famille de pokemons
                    sql = "INSERT INTO famille(id_pokemon_base,id_pokemon_level_2) VALUES (%s, %s)"
                    cursor.execute(sql, (id_base, id_level_2))
                    conn.commit()

def link_faiblesse(data):
    '''
        :param data: variable contenant toutes les données de l'api
        peuple la table link_faiblesse de la base de données
    '''
    for i in range(1,1026):
        for elt in data[i]['resistances']:
            #on regarde les faiblesse du pokemon
            if elt['multiplier'] == 2:
                #on récupere l'id du type de la faiblesse du pokémon
                sql = "SELECT id FROM type WHERE nom=%s"
                cursor.execute(sql, (elt['name']))
                id_type = cursor.fetchone()[0]

                #insertion dans la table lin_faiblesse
                sql = "INSERT INTO link_faiblesse(id_pokemon,id_type) VALUES (%s, %s)"
                cursor.execute(sql, (data[i]['pokedex_id'], id_type))
                conn.commit()

def link_region(data):
    '''
        :param data: variable contenant toutes les données de l'api
        peuple la table link_région de la base de données
    '''
    for i in range(1, 1026):
        #on vérifie que le pokémon possède bien une forme régionale spéciale
        if data[i]['formes'] is not None:
            for elt in data[i]['formes']:
                #on récupère l'id de la région
                sql = "SELECT id FROM region WHERE nom=%s"
                cursor.execute(sql, (elt['region']))
                id_region = cursor.fetchone()[0]

                #insertion dans la table link_region
                sql = "INSERT INTO link_region(id_pokemon,id_region) VALUES (%s, %s)"
                cursor.execute(sql, (data[i]['pokedex_id'], id_region))
                conn.commit()

def link_type(data):
    '''
    :param data: variable contenant toutes les données de l'api
    peuple la table link_type de la base de données
    '''
    for i in range(1,1026):
        for elt in data[i]['types']:
            #on récupère l'id des types associés au pokémon
            sql = "SELECT id FROM type WHERE nom=%s"
            cursor.execute(sql, (elt['name']))
            type_id = cursor.fetchone()[0]

            #insertion dans la table link_type
            sql = "INSERT INTO link_type(id_type, id_pokemon) VALUES (%s, %s)"
            cursor.execute(sql, (type_id, data[i]['pokedex_id']))
            conn.commit()

#Code principal, appel de toutes les fonctions
with conn.cursor() as cursor:
    type(data)
    print("type ok")
    categorie(data)
    print("categorie ok")
    pokemon(data)
    print("pokemon ok")
    region(data)
    print("region ok")
    famille(data)
    print("famille ok")
    link_type(data)
    print("link_type ok")
    link_region(data)
    print("link_region ok")
    link_faiblesse(data)
    print("link_faiblesse ok")
    print("Peuplement terminé")
