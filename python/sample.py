import requests

URL = '<url>'
TOKEN = '<access_token>'
AUDIO = '<audio_file_path>'

def main():
    headers = {'Authorization':f'Bearer {TOKEN}'}
    audio_file = {'file':open(AUDIO,'rb')}

    res = requests.post(URL, files=audio_file, headers=headers).json()
    if res['code'] == 200:

        for data in res['results']:
            for key in data.keys():
                print(f'{key}:', data[key])
    else:
        print(res['code'])
        print(res['error']['message'])

if __name__ == '__main__':
    main()
