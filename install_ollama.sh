#!/bin/bash

echo "בדיקת תאימות מערכת ל-Ollama ולמודל mistral..."

# בדיקת תמיכה ב-AVX
if grep -q avx /proc/cpuinfo; then
  echo "✓ המעבד תומך ב-AVX"
else
  echo "✗ המעבד לא תומך ב-AVX — Ollama לא יעבוד על שרת זה"
  exit 1
fi

# בדיקת זיכרון RAM (לפחות 8GB)
RAM=$(free -g | awk '/^Mem:/{print $2}')
if [ "$RAM" -ge 8 ]; then
  echo "✓ זיכרון RAM מספיק: ${RAM}GB"
else
  echo "✗ נדרש לפחות 8GB RAM. כרגע יש: ${RAM}GB"
  exit 1
fi

# התקנת ollama
if ! command -v ollama &> /dev/null; then
  echo "מתקין Ollama..."
  curl -fsSL https://ollama.com/install.sh | sh
else
  echo "✓ Ollama כבר מותקן"
fi

# התחלת שירות ollama
echo "מתניע את Ollama..."
ollama serve > /dev/null 2>&1 &

# המתנה לשירות
sleep 5

# טעינת המודל mistral
echo "מוריד את המודל mistral..."
ollama pull mistral

# בדיקת תקשורת עם ollama
if curl -s http://localhost:11434/api/tags | grep -q mistral; then
  echo "✓ המודל mistral זמין כעת בכתובת http://localhost:11434"
else
  echo "✗ תקלה בטעינת המודל או שירות Ollama לא פועל"
  exit 1
fi

echo "התקנה והפעלה הושלמו בהצלחה"
