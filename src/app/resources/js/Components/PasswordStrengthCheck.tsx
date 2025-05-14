import React, { useEffect, useState } from 'react';

interface Props {
  password: string;
}

export default function PasswordStrengthCheck({ password }: Props) {
  const [isValid, setIsValid] = useState<boolean | null>(null);

  useEffect(() => {
    if (!password) {
      setIsValid(null);
      return;
    }

    const regex = /^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)(?=.*?[@#$\-_])[a-zA-Z\d@#$\-_]{8,}$/;
    setIsValid(regex.test(password));
  }, [password]);

  return (
    <p className={`text-sm mt-2 ${isValid === null ? 'text-gray-500' : isValid ? 'text-green-600' : 'text-red-500'}`}>
      {isValid === null
        ? ''
        : isValid
          ? '✅ 条件を満たしています'
          : '❌ 小文字・大文字・数字・記号（@ # $ - _）を含む8文字以上にしてください'}
    </p>
  );
}
