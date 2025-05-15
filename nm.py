from ollama import Client

client = Client('https://2925-34-48-131-227.ngrok-free.app')
response = client.chat(messages=[{'role': 'user', 'content': 'Hi'}])
print(response['message']['content'])
