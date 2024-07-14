type MethodType = "GET" | "POST" | "PUT" | "DELETE" | "PATCH";

export const useApiFetch = async (
  path: string,
  method: MethodType = "GET",
  body?: object
) => {
  const config = useRuntimeConfig();
  const { token } = useMyAuthStore();
  let csrfToken = useCookie("XSRF-TOKEN").value as string;

  if (!csrfToken) {
    await useFetch(`${config.public.API_URL}/sanctum/csrf-cookie`, {
      credentials: "include",
      watch: false,
    });

    csrfToken = useCookie("XSRF-TOKEN").value as string;
  }

  let header = [] as any;

  if (method !== "GET" || body) {
    header["X-XSRF-TOKEN"] = csrfToken;
    header["Accept"] = "application/json";
  }

  if (path.startsWith("/api")) {
    header["Authorization"] = `Bearer ${token}`;
  }

  if (import.meta.client) {
    const { data, error } = await useFetch<any>(config.public.API_URL + path, {
      method: method,
      body: body,
      headers: {
        ...header,
      },
      credentials: "include",
      watch: false,
    });

    return { data, error };
  }
};
